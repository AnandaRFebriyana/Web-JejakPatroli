pipeline {
  agent {
    docker {
      image 'node:14-alpine'
      args '-v $HOME/.npm:/root/.npm'
    }
  }
  environment {
    AUTHOR = "Muhammad Rofiqi"
    PROJECT = "Web-JejakPatroli"
    REPO_URL = "https://github.com/AnandaRFebriyana/Web-JejakPatroli"
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
      }
    }
    stage("Build") {
      steps {
        echo("Start Build")
        sh "npm install && npm run build"
        echo("Finish Build")
      }
    }
    stage("Test") {
      steps {
        echo("Start Test")
        sh "npm test || true"
        echo("Finish Test")
      }
    }
    stage("Deploy") {
      agent any  // Kembali ke agent default untuk deployment
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
          if (TARGET_ENV == 'PRODUCTION') {
            echo("Deploying to PRODUCTION environment")
            // Tambahkan langkah deploy ke production
          } else if (TARGET_ENV == 'STAGING') {
            echo("Deploying to STAGING environment")
            // Tambahkan langkah deploy ke staging
          } else {
            echo("Deploying to DEV environment")
            // Tambahkan langkah deploy ke development
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
    }
  }
}
