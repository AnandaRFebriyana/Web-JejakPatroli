pipeline {
    agent any

    environment {
        PATH = "/usr/local/bin:/usr/bin:/bin:/usr/local/sbin:/usr/sbin:/sbin:$PATH"
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
                script {
                    // Build dengan no cache untuk memastikan dependencies terupdate
                    dockerCompose.build('--no-cache')
                }
            }
        }

        stage('Test') {
            steps {
                script {
                    // Setup environment test
                    sh 'docker-compose run --rm app composer install'
                    sh 'docker-compose run --rm app cp .env.example .env'
                    sh 'docker-compose run --rm app php artisan key:generate'
                    
                    // Jalankan test
                    try {
                        sh 'docker-compose run --rm app php artisan test'
                    } catch (err) {
                        error "Tests failed!"
                    }
                }
            }
        }

        stage('Deploy') {
            steps {
                script {
                    // Stop dan remove container yang ada
                    sh 'docker-compose down || true'
                    
                    // Jalankan service
                    sh 'docker-compose up -d --force-recreate'
                    
                    // Tunggu sampai container siap
                    sleep(time: 15, unit: 'SECONDS')
                    
                    // Setup database
                    sh 'docker-compose exec app php artisan migrate --force'
                    sh 'docker-compose exec app php artisan storage:link'
                    
                    // Cleanup
                    sh 'docker system prune -f'
                }
            }
        }
    }

    post {
        always {
            // Clean workspace dan docker resources
            cleanWs()
            sh 'docker-compose down || true'
        }
        success {
            // Notifikasi sukses
            slackSend(color: '#00FF00', message: "Pipeline SUCCESS - ${env.JOB_NAME} #${env.BUILD_NUMBER}")
            sh 'echo "Deployment successful! Access at http://159.223.47.2"'
        }
        failure {
            // Notifikasi gagal
            slackSend(color: '#FF0000', message: "Pipeline FAILED - ${env.JOB_NAME} #${env.BUILD_NUMBER}")
            sh 'docker-compose logs --tail=50 app > app_logs.txt'
            archiveArtifacts artifacts: 'app_logs.txt'
        }
    }
}
