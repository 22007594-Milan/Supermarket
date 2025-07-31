pipeline {
  agent any

  environment {
    SONAR_PROJECT_KEY = 'my-fyp-project'
    SONAR_HOST_URL = 'http://sonarqube:9000' // Change to http://172.17.0.1:9000 if needed
  }

  stages {
    stage('📦 Clone Repository') {
      steps {
        echo 'Cloning from GitHub...'
        git credentialsId: 'github-creds',
            url: 'https://github.com/NivethLegend/supermarket-FYP.git',
            branch: 'main'
      }
    }

    stage('🔧 Build') {
      steps {
        echo 'Running build steps...'
        sh 'echo Building...'
      }
    }

    stage('🧪 Test & Analyze') {
      parallel {
        stage('Dummy API Test') {
          steps {
            echo 'Running dummy API test...'
            sh 'echo Testing dummy API...'
          }
        }

        stage('SonarQube Analysis') {
          steps {
            echo 'Running SonarQube analysis...'

            withCredentials([string(credentialsId: 'jenkins-token', variable: 'SONAR_TOKEN')]) {
              sh '''
                docker run --rm \
                  --network fyp_fyp_devnet \
                  -v /home/niveth/FYP/FYP:/usr/src \
                  sonarsource/sonar-scanner-cli \
                  -Dsonar.projectKey=my-fyp-project \
                  -Dsonar.sources=. \
                  -Dsonar.host.url=http://sonarqube:9000 \
                  -Dsonar.token=sqa_1246957a4bfe4c46085d5a2bd485ecfc6ecca25a \
                  -Dsonar.iac.skip=true
              '''
            }
          }
        }
      }
    }

    stage('🛑 Gatekeeper Approval') {
      steps {
        script {
          input(
            message: 'Approve deployment to production?',
            ok: 'Deploy'
          )
        }
      }
    }

    stage('🚀 Deploy') {
      steps {
        echo 'Deploying application...'
        sh 'echo Deploying...'
      }
    }
  }

  post {
    success {
      echo '✅ Pipeline completed successfully!'
    }
    failure {
      echo '❌ Pipeline failed.' 
    }
  }
}


