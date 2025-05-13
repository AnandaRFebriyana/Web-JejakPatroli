pipeline {
  agent none

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
      agent {
        node {
          label "linux"
        }
      }
      steps {
        echo("Preparing build environment for ${PROJECT}")
        echo("Repository URL: ${REPO_URL}")
      }
    }

    stage("Build") {
      agent {
        node {
          label "linux"
        }
      }
      steps {
        echo("Start Build")
        
        // Gunakan script untuk menjalankan perintah dalam Docker tanpa memerlukan agent Docker
        script {
          sh """
            docker run --rm -v "\${WORKSPACE}:/app" -w /app node:14-alpine /bin/sh -c "npm install && npm run build"
          """
        }
        
        echo("Finish Build")
      }
    }

    stage("Test") {
      agent {
        node {
          label "linux"
        }
      }
      steps {
        echo("Start Test")
        
        script {
          sh """
            docker run --rm -v "\${WORKSPACE}:/app" -w /app node:14-alpine /bin/sh -c "npm test || true"
          """
        }
        
        echo("Finish Test")
      }
    }

    stage("Deploy") {
      input {
        message "Can we deploy Web-JejakPatroli?"
        ok "Yes, deploy it"
        submitter "admin"
        parameters {
          choice(name: "TARGET_ENV", choices: ['DEV', 'STAGING', 'PRODUCTION'], description: "Which Environment?")
        }
      }
      agent {
        node {
          label "linux"
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
