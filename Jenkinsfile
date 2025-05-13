pipeline {
    agent any
    
    environment {
        // Definisikan variabel lingkungan yang dibutuhkan
        APP_NAME = 'web-jejakpatroli'
        DOCKER_HUB_CREDS = credentials('dockerhub') // Pastikan kredensial ini sudah diatur di Jenkins
    }
    
    stages {
        stage('Checkout') {
            steps {
                // Checkout kode dari GitHub
                checkout scm
                echo 'Checkout selesai'
            }
        }
        
        stage('Build') {
            steps {
                // Jika ini adalah aplikasi Node.js/React/Vue
                sh 'npm install'
                sh 'npm run build'
                echo 'Build selesai'
            }
        }
        
        stage('Test') {
            steps {
                // Jalankan unit test
                sh 'npm run test'
                echo 'Unit tests selesai'
            }
        }
        
        stage('Build Docker Image') {
            steps {
                // Build Docker image
                sh "docker build -t ${env.APP_NAME}:${env.BUILD_NUMBER} ."
                sh "docker tag ${env.APP_NAME}:${env.BUILD_NUMBER} ${env.DOCKER_HUB_CREDS_USR}/${env.APP_NAME}:${env.BUILD_NUMBER}"
                sh "docker tag ${env.APP_NAME}:${env.BUILD_NUMBER} ${env.DOCKER_HUB_CREDS_USR}/${env.APP_NAME}:latest"
                echo 'Docker build selesai'
            }
        }
        
        stage('Push to Docker Hub') {
            steps {
                // Login ke Docker Hub dan push image
                sh "echo ${env.DOCKER_HUB_CREDS_PSW} | docker login -u ${env.DOCKER_HUB_CREDS_USR} --password-stdin"
                sh "docker push ${env.DOCKER_HUB_CREDS_USR}/${env.APP_NAME}:${env.BUILD_NUMBER}"
                sh "docker push ${env.DOCKER_HUB_CREDS_USR}/${env.APP_NAME}:latest"
                echo 'Push ke Docker Hub selesai'
            }
        }
        
        stage('Deploy to Production') {
            steps {
                // Contoh deployment, sesuaikan dengan kebutuhan Anda
                // Ini bisa berupa SSH ke server atau menggunakan Kubernetes
                echo 'Deploy ke production selesai'
                
                // Contoh jika menggunakan SSH untuk deploy ke server
                // sshagent(['ssh-credentials-id']) {
                //     sh '''
                //         ssh user@production-server "cd /path/to/app && \
                //         docker pull username/${APP_NAME}:latest && \
                //         docker-compose down && \
                //         docker-compose up -d"
                //     '''
                // }
            }
        }
    }
    
    post {
        always {
            // Bersihkan workspace setelah build
            cleanWs()
            
            // Bersihkan images Docker yang tidak digunakan
            sh "docker system prune -f"
        }
        
        success {
            echo 'Pipeline berhasil! Web JejakPatroli sudah diperbarui.'
        }
        
        failure {
            echo 'Pipeline gagal! Silakan periksa log untuk detail lebih lanjut.'
        }
    }
}
