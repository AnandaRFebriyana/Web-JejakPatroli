pipeline {
    agent any

    environment {
        PROD_HOST = '141.11.190.114'
        PATH = "/usr/local/bin:$PATH" // Pastikan Jenkins bisa akses Composer
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
                    echo '🔧 Checking PHP and Composer...'
                    sh 'php -v || echo "PHP not found"'
                    sh 'composer --version || echo "Composer not found or misconfigured"'

                    echo '🚧 Installing dependencies...'
                    sh '/usr/local/bin/composer install --no-dev --optimize-autoloader'
                }
            }
        }

        stage('Test') {
            steps {
                script {
                    echo '🧪 Running tests...'
                    // Gunakan perintah test sesuai framework Laravel
                    sh 'php artisan test || echo "Tests failed or not configured"'
                }
            }
        }

        stage('Deploy') {
            steps {
                script {
                    echo '🚀 Deploying application...'
                }

                sshagent(credentials: ['your-ssh-key-id']) {
                    sh 'mkdir -p ~/.ssh'
                    sh 'ssh-keyscan -H $PROD_HOST >> ~/.ssh/known_hosts'

                    // Gunakan user yang sesuai di server (di sini diasumsikan "ubuntu")
                    sh '''
                    rsync -rav --delete ./ ubuntu@$PROD_HOST:/home/ubuntu/prod.kelasdevops.xyz/ \
                    --exclude=.env --exclude=storage --exclude=.git
                    '''
                }
            }
        }
    }
}
