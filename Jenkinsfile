pipeline {
    agent any

    environment {
        PROD_HOST = 'IP_ADDRESS_SERVER_PRODUCTION'
        SSH_CREDENTIALS = 'ssh-prod' // Sesuai dengan ID credentials di Jenkins
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scmGit(
                    branches: [[name: 'main']],
                    userRemoteConfigs: [[url: 'https://github.com/AnandaRFebriyana/Web-JejakPatroli']]
                )
            }
        }

        stage('Build') {
            steps {
                script {
                    echo 'Building application...'
                }
            }
        }

        stage('Test') {
            steps {
                script {
                    echo 'Running tests...'
                }
            }
        }

        stage('Deploy') {
            steps {
                script {
                    echo 'Deploying application...'
                }

                sshagent (credentials: [SSH_CREDENTIALS]) {
                    sh 'mkdir -p ~/.ssh'
                    sh 'ssh-keyscan -H "$PROD_HOST" >> ~/.ssh/known_hosts'

                    // Copy project files ke server menggunakan rsync
                    sh '''
                    rsync -rav --delete ./ ubuntu@$PROD_HOST:/home/ubuntu/prod.kelasdevops.xyz/ \
                    --exclude=.env --exclude=storage --exclude=.git
                    '''
                }
            }
        }
    }
}
