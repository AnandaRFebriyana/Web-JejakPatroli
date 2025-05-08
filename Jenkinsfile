pipeline {
    agent any

    environment {
        PROD_HOST = '141.11.190.114'  // Hanya alamat IP atau hostname, tanpa 'root@' karena sudah diatur di SSH Key Jenkins
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
                    // Tambahkan perintah build di sini, misalnya menjalankan composer atau npm
                    sh 'composer install --no-dev --optimize-autoloader'
                }
            }
        }

        stage('Test') {
            steps {
                script {
                    echo 'Running tests...'
                    // Jika Anda memiliki perintah test, misalnya PHPUnit
                    sh 'php artisan test'
                }
            }
        }

        stage('Deploy') {
            steps {
                script {
                    echo 'Deploying application...'
                }
                // Menggunakan credentials SSH
                sshagent(credentials: ['your-ssh-key-id']) { // Gantilah 'your-ssh-key-id' dengan ID kredensial SSH yang telah Anda buat di Jenkins
                    // Setup SSH untuk terhubung ke server
                    sh 'mkdir -p ~/.ssh'
                    sh 'ssh-keyscan -H $PROD_HOST >> ~/.ssh/known_hosts'

                    // Menggunakan rsync untuk menyalin aplikasi ke server
                    sh '''
                    rsync -rav --delete ./ ubuntu@$PROD_HOST:/home/ubuntu/prod.kelasdevops.xyz/ \
                    --exclude=.env --exclude=storage --exclude=.git
                    '''
                }
            }
        }
    }
}
