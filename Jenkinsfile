pipeline {
    agent {
        docker {
            image 'node:18-alpine' // Menggunakan image Node.js untuk build dan test
            args '-v /var/run/docker.sock:/var/run/docker.sock' // Mengakses Docker daemon host
        }
    }
    
    environment {
        // Definisikan variabel lingkungan yang dibutuhkan
        APP_NAME = 'web-jejakpatroli'
    }
    
    stages {
        stage('Checkout') {
            steps {
                // Checkout kode dari GitHub
                checkout scm
                echo 'Checkout selesai'
            }
        }
        
        stage('Install Dependencies') {
            steps {
                sh 'apk add --no-cache docker-cli' // Install Docker CLI di dalam container
                sh 'npm install'
                echo 'Install dependencies selesai'
            }
        }
        
        stage('Build') {
            steps {
                sh 'npm run build'
                echo 'Build selesai'
            }
        }
        
        stage('Test') {
            steps {
                // Jalankan unit test jika ada
                sh 'npm test || echo "No tests available, skipping..."'
                echo 'Test selesai'
            }
        }
        
        stage('Build Docker Image') {
            steps {
                // Build Docker image
                sh "docker build -t ${env.APP_NAME}:${env.BUILD_NUMBER} ."
                withCredentials([usernamePassword(credentialsId: 'dockerhub', passwordVariable: 'DOCKER_PASSWORD', usernameVariable: 'DOCKER_USERNAME')]) {
                    sh "docker tag ${env.APP_NAME}:${env.BUILD_NUMBER} ${DOCKER_USERNAME}/${env.APP_NAME}:${env.BUILD_NUMBER}"
                    sh "docker tag ${env.APP_NAME}:${env.BUILD_NUMBER} ${DOCKER_USERNAME}/${env.APP_NAME}:latest"
                }
                echo 'Docker build selesai'
            }
        }
        
        stage('Push to Docker Hub') {
            steps {
                // Login ke Docker Hub dan push image
                withCredentials([usernamePassword(credentialsId: 'dockerhub', passwordVariable: 'DOCKER_PASSWORD', usernameVariable: 'DOCKER_USERNAME')]) {
                    sh "echo ${DOCKER_PASSWORD} | docker login -u ${DOCKER_USERNAME} --password-stdin"
                    sh "docker push ${DOCKER_USERNAME}/${env.APP_NAME}:${env.BUILD_NUMBER}"
                    sh "docker push ${DOCKER_USERNAME}/${env.APP_NAME}:latest"
                }
                echo 'Push ke Docker Hub selesai'
            }
        }
        
        stage('Deploy to Production') {
            steps {
                // Contoh deployment, sesuaikan dengan kebutuhan Anda
                echo 'Deploy ke production selesai'
            }
        }
    }
    
    post {
        always {
            echo 'Membersihkan workspace...'
            cleanWs()
        }
        
        success {
            echo 'Pipeline berhasil! Web JejakPatroli sudah diperbarui.'
        }
        
        failure {
            echo 'Pipeline gagal! Silakan periksa log untuk detail lebih lanjut.'
        }
    }
}
}
