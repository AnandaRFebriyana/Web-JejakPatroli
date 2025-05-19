pipeline {
    agent any

    environment {
        PATH = "/usr/local/bin:/usr/bin:/bin:/usr/local/sbin:/usr/sbin:/sbin:$PATH"
        DOCKER_HOST = "unix:///var/run/docker.sock"
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
                sh 'docker-compose build'
            }
        }

        stage('Test') {
            steps {
                sh 'docker-compose run --rm app php artisan test'
            }
        }

        stage('Deploy') {
            steps {
                sh 'docker-compose down'
                sh 'docker-compose up -d'
                sh 'docker-compose exec app php artisan migrate --force'
            }
        }
    }

    post {
        always {
            cleanWs()
        }
        success {
            slackSend(color: '#00FF00', message: 'Pipeline Succeeded')
        }
        failure {
            slackSend(color: '#FF0000', message: 'Pipeline Failed')
        }
    }
}
