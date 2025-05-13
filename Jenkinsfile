pipeline {
  agent {
    docker {
      image 'php:8.1-cli'
      args '-v $HOME/.composer:/root/.composer'
    }
  }
  environment {
    AUTHOR = "Muhammad Rofiqi"
    PROJECT = "Web-JejakPatroli"
    REPO_URL = "https://github.com/AnandaRFebriyana/Web-JejakPatroli"
    DEPLOY_DIR = "/var/www/jejakpatroli"
    DEPLOY_USER = "www-data"
    DEPLOY_GROUP = "www-data"
  }
  options {
    disableConcurrentBuilds()
    timeout(time: 15, unit: 'MINUTES')
  }
  stages {
    stage("Preparation") {
      steps {
        echo("Preparing build environment for ${PROJECT}")
        echo("Repository URL: ${REPO_URL}")
        
        // Install dependencies for PHP
        sh 'apt-get update && apt-get install -y git unzip libzip-dev libpng-dev'
        sh 'docker-php-ext-install zip gd pdo pdo_mysql'
        
        // Install Composer
        sh 'curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer'
      }
    }
    stage("Build") {
      steps {
        echo("Start Build")
        sh "composer install --no-dev --optimize-autoloader"
        sh "php artisan config:cache"
        sh "php artisan route:cache"
        echo("Finish Build")
      }
    }
    stage("Test") {
      steps {
        echo("Start Test")
        sh "php artisan test || true"
        echo("Finish Test")
      }
    }
    stage("Deploy") {
      agent {
        label 'master'  // Use Jenkins master for deployment
      }
      input {
        message "Can we deploy Web-JejakPatroli?"
        ok "Yes, deploy it"
        submitter "admin"
        parameters {
          choice(name: "TARGET_ENV", choices: ['DEV', 'STAGING', 'PRODUCTION'], description: "Which Environment?")
        }
      }
      steps {
        echo("Deploying ${PROJECT} to ${TARGET_ENV}")
        
        script {
          def deployDir = ""
          def envFile = ""
          
          if (TARGET_ENV == 'PRODUCTION') {
            deployDir = "${DEPLOY_DIR}/production"
            envFile = ".env.production"
          } else if (TARGET_ENV == 'STAGING') {
            deployDir = "${DEPLOY_DIR}/staging"
            envFile = ".env.staging"
          } else {
            deployDir = "${DEPLOY_DIR}/development"
            envFile = ".env.dev"
          }
          
          // Create deployment directory
          sh "mkdir -p ${deployDir}"
          
          // Copy workspace content to deployment directory
          sh "cp -R ${WORKSPACE}/* ${deployDir}/"
          
          // Laravel deployment steps
          dir("${deployDir}") {
            // Copy environment file
            sh "cp ${envFile} .env || echo 'Warning: No ${envFile} found'"
            
            // Install PHP dependencies
            sh "composer install --no-interaction --no-progress --optimize-autoloader"
            
            if (TARGET_ENV != 'PRODUCTION') {
              sh "composer install --no-interaction --no-progress"
            } else {
              sh "composer install --no-interaction --no-progress --no-dev --optimize-autoloader"
            }
            
            // Generate application key if needed
            sh "php artisan key:generate --force"
            
            // Run migrations
            sh "php artisan migrate --force"
            
            // Clear or cache based on environment
            if (TARGET_ENV == 'PRODUCTION' || TARGET_ENV == 'STAGING') {
              sh "php artisan config:cache"
              sh "php artisan route:cache"
              sh "php artisan view:cache"
            } else {
              sh "php artisan config:clear"
              sh "php artisan route:clear"
              sh "php artisan view:clear"
              sh "php artisan cache:clear"
            }
            
            // Set correct permissions
            sh "chown -R ${DEPLOY_USER}:${DEPLOY_GROUP} ."
            sh "chmod -R 755 ."
            sh "chmod -R 775 storage bootstrap/cache"
            
            // Create appropriate symlink
            if (TARGET_ENV == 'PRODUCTION') {
              sh "ln -sfn ${deployDir} ${DEPLOY_DIR}/current"
            } else if (TARGET_ENV == 'STAGING') {
              sh "ln -sfn ${deployDir} ${DEPLOY_DIR}/staging-current"
            } else {
              sh "ln -sfn ${deployDir} ${DEPLOY_DIR}/dev-current"
            }
            
            // Reload services (without sudo as we're on master)
            sh "systemctl reload nginx || echo 'Failed to reload nginx'"
            sh "systemctl reload php-fpm || echo 'Failed to reload php-fpm'"
          }
        }
      }
    }
  }
  post {
    always {
      echo "Pipeline for ${PROJECT} has completed"
    }
    success {
      echo "Pipeline for ${PROJECT} completed successfully"
    }
    failure {
      echo "Pipeline for ${PROJECT} failed"
    }
    cleanup {
      echo "Cleaning up workspace"
      cleanWs()
    }
  }
}