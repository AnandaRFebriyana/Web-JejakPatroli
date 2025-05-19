pipeline {
    agent any
    
    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }
        
        stage('Explore Repository') {
            steps {
                // List files in the workspace to see what we have
                sh 'ls -la'
                
                // Try to find composer.json
                sh 'find . -name "composer.json" || echo "No composer.json found"'
            }
        }
        
        stage('Setup Environment') {
            steps {
                sh 'cp .env.example .env || echo "No .env.example file found"'
                sh 'if [ -f ".env" ]; then sed -i s/DB_HOST=127.0.0.1/DB_HOST=mysql/g .env; fi'
                sh 'if [ -f ".env" ]; then sed -i s/DB_DATABASE=laravel/DB_DATABASE=jejakpatroli/g .env; fi'
                sh 'if [ -f ".env" ]; then sed -i s/DB_USERNAME=root/DB_USERNAME=root/g .env; fi'
                sh 'if [ -f ".env" ]; then sed -i s/DB_PASSWORD=.*/DB_PASSWORD=/g .env; fi'
            }
        }
        
        stage('Install Dependencies') {
            steps {
                // First check if composer.json exists
                script {
                    def composerExists = sh(script: 'test -f composer.json && echo "true" || echo "false"', returnStdout: true).trim()
                    
                    if (composerExists == 'true') {
                        sh 'docker run --rm -v "$(pwd)":/app composer:latest composer install --no-interaction'
                    } else {
                        echo "No composer.json found. Skipping dependency installation."
                        // Try to initialize a new Laravel project if needed
                        def initLaravel = false // Change to true if you want to initialize Laravel
                        
                        if (initLaravel) {
                            sh 'docker run --rm -v "$(pwd)":/app composer:latest composer create-project --prefer-dist laravel/laravel .'
                        }
                    }
                }
            }
        }
        
        stage('Generate Key') {
            when {
                expression { return sh(script: 'test -f artisan && echo "true" || echo "false"', returnStdout: true).trim() == 'true' }
            }
            steps {
                sh 'docker run --rm -v "$(pwd)":/app -w /app php:8.1-cli php artisan key:generate'
            }
        }
        
        stage('Run Tests') {
            when {
                expression { return sh(script: 'test -f artisan && echo "true" || echo "false"', returnStdout: true).trim() == 'true' }
            }
            steps {
                sh 'docker run --rm -v "$(pwd)":/app -w /app php:8.1-cli php artisan test'
            }
        }
        
        stage('Deploy to Production') {
            when {
                allOf {
                    branch 'main'
                    expression { return sh(script: 'test -f artisan && echo "true" || echo "false"', returnStdout: true).trim() == 'true' }
                }
            }
            steps {
                echo 'Deploying to production...'
                // Add your deployment steps here
            }
        }
        
        stage('Setup Monitoring') {
            when {
                allOf {
                    branch 'main'
                    expression { return sh(script: 'test -f artisan && echo "true" || echo "false"', returnStdout: true).trim() == 'true' }
                }
            }
            steps {
                echo 'Setting up monitoring...'
                // Add your monitoring setup steps here
            }
        }
    }
    
    post {
        always {
            echo 'Pipeline completed'
        }
        success {
            echo 'Pipeline succeeded'
        }
        failure {
            echo 'Pipeline failed'
        }
    }
}
