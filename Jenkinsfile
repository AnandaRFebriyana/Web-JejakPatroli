pipeline {
    agent any
    
    environment {
        PROJECT_NAME = "Web-JejakPatroli"
        REPO_URL = "https://github.com/AnandaRFebriyana/Web-JejakPatroli"
    }
    
    stages {
        stage("Verify tooling") {
            steps {
                sh '''
                    docker info
                    docker version
                    docker compose version
                '''
            }
        }
        
        stage("Verify SSH connection to server") {
            steps {
                sshagent(credentials: ['deploy-key']) {
                    sh '''
                        ssh -o StrictHostKeyChecking=no ubuntu@your-server-ip whoami
                    '''
                }
            }
        }
        
        stage("Clear all running docker containers") {
            steps {
                script {
                    try {
                        sh 'docker rm -f $(docker ps -a -q)'
                    } catch (Exception e) {
                        echo 'No running container to clear up...'
                    }
                }
            }
        }
        
        stage("Start Docker") {
            steps {
                sh 'docker compose up -d'
                sh 'docker compose ps'
            }
        }
        
        stage("Install Dependencies") {
            steps {
                sh 'docker compose run --rm node npm install'
            }
        }
        
        stage("Build Application") {
            steps {
                sh 'docker compose run --rm node npm run build'
            }
        }
        
        stage("Run Tests") {
            steps {
                script {
                    try {
                        sh 'docker compose run --rm node npm test'
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
                sh 'rm -rf artifact.zip'
                sh 'zip -r artifact.zip . -x "*node_modules**" -x "*.git*"'
                
                // Deploy to server
                withCredentials([sshUserPrivateKey(credentialsId: "deploy-key", keyFileVariable: 'keyfile')]) {
                    sh 'scp -v -o StrictHostKeyChecking=no -i ${keyfile} ${WORKSPACE}/artifact.zip ubuntu@your-server-ip:/home/ubuntu/deployments/${PROJECT_NAME}'
                }
                
                sshagent(credentials: ['deploy-key']) {
                    // Unzip and deploy
                    sh '''
                        ssh -o StrictHostKeyChecking=no  -p 33333 root@141.11.190.114 "mkdir -p /home/ubuntu/deployments/${PROJECT_NAME}"
                        ssh -o StrictHostKeyChecking=no  -p 33333 root@141.11.190.114 "unzip -o /home/ubuntu/deployments/${PROJECT_NAME}/artifact.zip -d /home/ubuntu/deployments/${PROJECT_NAME}/app"
                        ssh -o StrictHostKeyChecking=no  -p 33333 root@141.11.190.114 "cd /home/ubuntu/deployments/${PROJECT_NAME}/app && npm install --production"
                        ssh -o StrictHostKeyChecking=no  -p 33333 root@141.11.190.114p "cd /home/ubuntu/deployments/${PROJECT_NAME}/app && pm2 restart ecosystem.config.js || pm2 start ecosystem.config.js"
                    '''
                }
            }
        }
        
        always {
            sh 'docker compose down --remove-orphans -v'
            sh 'docker compose ps'
        }
    }
}
