pipeline {
    agent any
    
    tools {
        nodejs 'NodeJS' // Pastikan Anda telah mengkonfigurasi NodeJS di Jenkins Global Tool Configuration
    }
    
    stages {
        stage('Build') {
            steps {
                sh 'npm install'
                sh 'npm run build'
            }
        }
        
        stage('Test') {
            steps {
                sh 'npm test'
            }
        }
        
        stage('Deploy') {
            steps {
                echo 'Deploying...'
                // Add your deployment commands here
            }
        }
    }
}
