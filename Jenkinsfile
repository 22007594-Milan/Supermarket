pipeline {
  agent any

  environment {
    SONAR_AUTH_TOKEN = credentials('sonar-token') // 🔐 Your SonarQube token credential
  }

  stages {
    stage('Clone Repository') {
    steps {
        echo '📦 Cloning from GitHub...'
        git url: 'https://github.com/22007594-Milan/Supermarket.git', branch: 'main'
    }
}


    stage('Build') {
      steps {
        echo '🔧 Running build steps...'
        // 🛠️ Add build commands here
      }
    }

    stage('Test') {
      parallel {
        stage('Dummy API Test') {
          steps {
            echo '🧪 Running dummy API test...'
            // 💬 Add your test logic here
          }
        }


 stage('SonarQube Analysis') {
    steps {
        echo 'Running SonarQube analysis...'
        withCredentials([string(credentialsId: 'jenkins-token', variable: 'SONAR_TOKEN')]) {
            // List files in Jenkins workspace BEFORE running Docker (for debugging)
            sh 'ls -l $WORKSPACE'
            sh 'ls -l $WORKSPACE/webapp'
            sh '''
                docker run --rm \
                  --network fyp_fyp_devnet \
                  -v $WORKSPACE:/usr/src \
                  -v $WORKSPACE/.sonar:/usr/src/.sonar \
                  sonarsource/sonar-scanner-cli:latest \
                  sh -c "ls -l /usr/src && ls -l /usr/src/webapp && sonar-scanner \
                    -Dsonar.projectKey=my-fyp-project \
                    -Dsonar.sources=webapp \
                    -Dsonar.host.url=http://sonarqube:9000 \
                    -Dsonar.token=$SONAR_TOKEN \
                    -Dsonar.iac.skip=true"
            '''
        }
    }
}
      
      }
    }

    stage('Gatekeeper Approval') {
        steps {
            script {
                input message: '✅ Approve to deploy to production?', ok: 'Approve Deployment'
            }
        }
    }


    stage('Deploy') {
      steps {
        echo '🚢 Deploying the application...'
        // 🚀 Add deployment logic here
      }
    }
  }

  post {
    success {
      echo '🟢 Pipeline passed! Well done.'
    }
    failure {
      echo '❌ Pipeline failed. But you? Never.'
    }
  }
}

