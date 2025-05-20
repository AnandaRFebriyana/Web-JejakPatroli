pipeline {
    agent any

    environment {
        PATH = "/usr/local/bin:/usr/bin:/bin:/usr/sbin:/sbin:$PATH"
        DOCKER_HOST = "unix:///var/run/docker.sock"
        COMPOSE_PROJECT_NAME = "jejakpatroli_jenkins"
    }

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main', 
                url: 'https://github.com/AnandaRFebriyana/Web-JejakPatroli.git'
            }
        }

        stage('Build') {
            steps {
                sh '/usr/local/bin/docker-compose build --no-cache'
            }
        }

        stage('Test') {
            steps {
                script {
                    try {
                        sh '/usr/local/bin/docker-compose run --rm app php artisan test'
                    } catch (err) {
                        error "Tests failed!"
                    }
                }
            }
        }

        stage('Deploy') {
            steps {
                script {
                    sh '/usr/local/bin/docker-compose down || true'
                    sh '/usr/local/bin/docker-compose up -d --force-recreate'
                    sleep(time: 15, unit: 'SECONDS')
                    sh '/usr/local/bin/docker-compose exec app php artisan migrate --force'
                }
            }
        }
    }

    post {
        always {
            cleanWs()
            sh '/usr/local/bin/docker-compose down || true'
        }
        success {
            echo 'Pipeline SUCCESS!'
            echo 'Aplikasi berhasil di-deploy di http://159.223.47.2'
        }
        failure {
            echo 'Pipeline FAILED!'
            sh '/usr/local/bin/docker-compose logs --tail=50 > docker_logs.txt'
            archiveArtifacts artifacts: 'docker_logs.txt'
        }
    }
}
