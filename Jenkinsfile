pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                script {
                    echo 'Checking out repository...'
                    git branch: 'main', url: 'https://github.com/AnandaRFebriyana/Web-JejakPatroli'
                }
            }
        }

        stage('Build') {
            steps {
                script {
                    echo 'Building application...'
                    // Tambahkan perintah build jika diperlukan, misalnya:
                    // sh './gradlew build'  (untuk Gradle)
                    // sh 'mvn package'      (untuk Maven)
                    // sh 'npm install'      (untuk Node.js)
                }
            }
        }

        stage('Test') {
            steps {
                script {
                    echo 'Running tests...'
                    // Tambahkan perintah untuk menjalankan unit test
                    // sh 'npm test'
                    // sh './gradlew test'
                }
            }
        }

        stage('Deploy') {
            steps {
                script {
                    echo 'Deploying application...'
                    // Tambahkan perintah untuk deploy ke server atau container
                    // sh 'scp target/app.jar user@server:/path/to/deploy'
                    // sh 'docker-compose up -d'
                }
            }
        }
    }
}
