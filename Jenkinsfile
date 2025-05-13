pipeline {
    agent any

    environment {
        PROD_HOST = '141.11.190.114'  // Ganti dengan alamat IP atau domain server produksi
        COMPOSER = '/usr/local/bin/composer'  // Pastikan Composer dapat diakses
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Build') {
            steps {
                script {
                    echo '🔧 Checking PHP and Composer versions...'
                    // Memastikan PHP dan Composer terinstal
                    sh 'php -v'
                    sh 'composer --version'

                    echo '🚧 Installing dependencies...'
                    // Install dependencies menggunakan Composer
                    sh '$COMPOSER install --no-dev --optimize-autoloader'
                }
            }
        }

        stage('Test') {
            steps {
                script {
                    echo '🧪 Running tests...'
                    // Jalankan tes Laravel menggunakan PHPUnit
                    sh 'php artisan test --env=testing'
                }
            }
        }

        stage('Deploy') {
            steps {
                script {
                    echo '🚀 Deploying application...'
                }

                // Gunakan Docker untuk menjalankan rsync dan SSH
                docker.image('agung3wi/alpine-rsync:1.1').inside('-u root') {
                    // Setup SSH untuk menghindari masalah 'host verification'
                    sh 'mkdir -p ~/.ssh'
                    sh 'ssh-keyscan -H "$PROD_HOST" > ~/.ssh/known_hosts'
                    
                    // Salin project ke server produksi menggunakan rsync
                    sh """
                    rsync -rav --delete ./laravel/ ubuntu@$PROD_HOST:/home/ubuntu/prod.kelasdevops.xyz/ \
                    --exclude=.env --exclude=storage --exclude=.git
                    """
                }
            }
        }
    }
}
