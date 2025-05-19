
pipeline {
    agent any
    
    options {
        // Add timeout to prevent hung builds
        timeout(time: 60, unit: 'MINUTES')
        // Discard old builds
        buildDiscarder(logRotator(numToKeepStr: '10'))
    }
    
    environment {
        // Define Docker parameters for better resource management
        DOCKER_ARGS = '--memory=512m --memory-swap=512m --cpus=0.5'
        // Define a common PHP Docker image to use
        PHP_IMAGE = 'php:8.1-cli-alpine'
        COMPOSER_IMAGE = 'composer:latest'
    }
    
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
                        // Add the --ignore-platform-req=ext-gd flag to avoid GD extension error
                        // Use environment variables for Docker arguments
                        sh "docker run --rm ${env.DOCKER_ARGS} -v \"$(pwd)\":/app ${env.COMPOSER_IMAGE} composer install --no-interaction --ignore-platform-req=ext-gd"
                    } else {
                        echo "No composer.json found. Skipping dependency installation."
                    }
                }
            }
        }
        
        stage('Generate Key') {
            when {
                expression { return sh(script: 'test -f artisan && echo "true" || echo "false"', returnStdout: true).trim() == 'true' }
            }
            steps {
                // Using a PHP image with GD extension installed for Laravel operations
                sh """
                docker run --rm ${env.DOCKER_ARGS} -v \"$(pwd)\":/app -w /app ${env.PHP_IMAGE} sh -c \"
                    apk add --no-cache freetype-dev libjpeg-turbo-dev libpng-dev && 
                    docker-php-ext-configure gd --with-freetype --with-jpeg && 
                    docker-php-ext-install gd && 
                    php artisan key:generate
                \"
                """
            }
        }
        
        stage('Run Tests') {
            when {
                expression { return sh(script: 'test -f artisan && echo "true" || echo "false"', returnStdout: true).trim() == 'true' }
            }
            steps {
                // Using a PHP image with GD extension installed for running tests
                sh """
                docker run --rm ${env.DOCKER_ARGS} -v \"$(pwd)\":/app -w /app ${env.PHP_IMAGE} sh -c \"
                    apk add --no-cache freetype-dev libjpeg-turbo-dev libpng-dev && 
                    docker-php-ext-configure gd --with-freetype --with-jpeg && 
                    docker-php-ext-install gd && 
                    php artisan test
                \"
                """
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
            // Thorough Docker cleanup
            script {
                // Stop all running containers created by this build
                sh 'docker ps -q --filter "status=running" | xargs -r docker stop || true'
                // Remove all containers created by this build
                sh 'docker ps -a -q | xargs -r docker rm -f || true'
                // Clean up any unused volumes
                sh 'docker volume prune -f || true'
                // Clean up any unused networks
                sh 'docker network prune -f || true'
                // Optional: clean up dangling images (use cautiously)
                // sh 'docker image prune -f || true'
            }
        }
        success {
            echo 'Pipeline succeeded'
        }
        failure {
            echo 'Pipeline failed'
            // Add notification steps here if needed
            // For example: slackSend channel: '#jenkins', color: 'danger', message: "Build failed: ${env.JOB_NAME} ${env.BUILD_NUMBER}"
        }
        unstable {
            echo 'Pipeline is unstable'
        }
    }
}
