pipeline {
    agent any
    
    environment {
        PROJECT_NAME = "Web-JejakPatroli"
        REPO_URL = "https://github.com/AnandaRFebriyana/Web-JejakPatroli"
        SERVER_IP = "141.11.190.114"
        SERVER_USER = "root"
        SERVER_PORT = "33333"
        DEPLOY_DIR = "/home/ubuntu/deployments/${PROJECT_NAME}"
    }
    
    stages {
        stage("Verify tooling") {
            steps {
                script {
                    try {
                        sh '''
                            set -x
                            docker info || echo "docker info failed"
                            docker version || echo "docker version failed"
                            docker compose version || docker-compose --version || echo "docker compose version failed"
                        '''
                    } catch (Exception e) {
                        echo "Tooling verification failed, but continuing pipeline: ${e.message}"
                    }
                }
            }
        }
        
        stage("Verify SSH connection to server") {
            steps {
                sshagent(credentials: ['deploy-key']) {
                    sh '''
                        ssh -o StrictHostKeyChecking=no -p ${SERVER_PORT} ${SERVER_USER}@${SERVER_IP} whoami
                    '''
                }
            }
        }
        
        stage("Clear all running docker containers") {
            steps {
                script {
                    try {
                        sh 'docker rm -f $(docker ps -a -q) || true'
                    } catch (Exception e) {
                        echo 'No running containers to clear up...'
                    }
                }
            }
        }
        
        stage("Start Docker") {
            steps {
                sh 'docker compose up -d || docker-compose up -d'
                sh 'docker compose ps || docker-compose ps'
            }
        }
        
        stage("Install Dependencies") {
            steps {
                sh 'docker compose run --rm node npm ci || docker-compose run --rm node npm ci'
            }
        }
        
        stage("Build Application") {
            steps {
                sh 'docker compose run --rm node npm run build || docker-compose run --rm node npm run build'
            }
        }
        
        stage("Run Tests") {
            steps {
                script {
                    try {
                        sh 'docker compose run --rm node npm test || docker-compose run --rm node npm test'
                    } catch (Exception e) {
                        echo 'Tests failed, but continuing the pipeline...'
                    }
                }
            }
        }
    }
    
    post {
        success {
            script {
                // Create deployment artifact
                sh 'cd "${WORKSPACE}"'
                sh 'rm -rf artifact.zip || true'
                sh 'zip -r artifact.zip . -x "*node_modules*" -x "*.git*"'
                
                // Deploy to server
                withCredentials([sshUserPrivateKey(credentialsId: "deploy-key", keyFileVariable: 'keyfile')]) {
                    sh '''
                        scp -v -o StrictHostKeyChecking=no -P ${SERVER_PORT} -i ${keyfile} ${WORKSPACE}/artifact.zip ${SERVER_USER}@${SERVER_IP}:${DEPLOY_DIR}/
                    '''
                }
                
                sshagent(credentials: ['deploy-key']) {
                    // Unzip and deploy
                    sh '''
                        ssh -o StrictHostKeyChecking=no -p ${SERVER_PORT} ${SERVER_USER}@${SERVER_IP} "mkdir -p ${DEPLOY_DIR}/app"
                        ssh -o StrictHostKeyChecking=no -p ${SERVER_PORT} ${SERVER_USER}@${SERVER_IP} "unzip -o ${DEPLOY_DIR}/artifact.zip -d ${DEPLOY_DIR}/app"
                        ssh -o StrictHostKeyChecking=no -p ${SERVER_PORT} ${SERVER_USER}@${SERVER_IP} "cd ${DEPLOY_DIR}/app && npm ci --production"
                        ssh -o StrictHostKeyChecking=no -p ${SERVER_PORT} ${SERVER_USER}@${SERVER_IP} "cd ${DEPLOY_DIR}/app && pm2 restart ecosystem.config.js || pm2 start ecosystem.config.js"
                        ssh -o StrictHostKeyChecking=no -p ${SERVER_PORT} ${SERVER_USER}@${SERVER_IP} "cd ${DEPLOY_DIR}/app && pm2 logs --lines 50"
                    '''
                }
            }
        }
        
        always {
            sh 'docker compose down --remove-orphans -v || docker-compose down --remove-orphans -v || true'
            sh 'docker compose ps || docker-compose ps || true'
        }
    }
}
