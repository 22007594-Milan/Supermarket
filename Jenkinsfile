pipeline {
  agent any

  environment {
    SONAR_AUTH_TOKEN = credentials('sonar-token') // 🔐 Your SonarQube token credential
  }

  stages {
    stage('Clone Repository') {
      steps {
        echo '📦 Cloning from GitHub...'
        git credentialsId: 'github-creds',
            url: 'https://github.com/NivethLegend/supermarket-FYP.git',
            branch: 'main'
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

        stage('SonarQube Scan') {
          steps {
            withSonarQubeEnv('SonarQube') {
              withCredentials([string(credentialsId: 'sonar-token', variable: 'SONAR_AUTH_TOKEN')]) {
                sh '''
                  echo "🧹 Preparing Sonar cache directory..."
                  mkdir -p .sonar/cache
                  chmod -R 777 .sonar

                  echo "⏳ Waiting for SonarQube to be ready..."
                  for i in {1..10}; do
                    STATUS=$(curl -s http://sonarqube:9000/api/system/status | grep -o '"status":"[A-Z]*"' | cut -d':' -f2 | tr -d '"')
                    echo "SonarQube status: $STATUS"
                    if [ "$STATUS" = "UP" ]; then
                        echo "✅ SonarQube is ready!"
                        break
                    fi
                    sleep 10
                  done 

                  echo "🚀 Running SonarScanner in Docker..."
                  docker run --rm \
                    --user root \
                    --network fyp_devnet \
                    -e SONAR_HOST_URL=http://sonarqube:9000 \
                    -e SONAR_TOKEN=$SONAR_AUTH_TOKEN \
                    -e SONAR_USER_HOME=/usr/src/.sonar \
                    -v "$PWD:/usr/src" \
                    -v "$PWD/.sonar:/usr/src/.sonar" \
                    sonarsource/sonar-scanner-cli \
                    -Dsonar.projectKey=supermarket \
                    -Dsonar.sources=. \
                    -Dsonar.working.directory=.scannerwork
                '''
              }
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

