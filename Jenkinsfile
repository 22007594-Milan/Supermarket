pipeline {
  agent any

  environment {
    SONAR_AUTH_TOKEN = credentials('sonar-token')  // Adjust to your credential ID
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
        // your build logic here
      }
    }

    stage('Test') {
      parallel {
        stage('Dummy API Test') {
          steps {
            withCredentials([string(credentialsId: 'sonar-token', variable: 'SONAR_AUTH_TOKEN')]) {
              echo '🧪 Running dummy API test...'
              // insert your test logic here
            }
          }
        }

        stage('SonarQube Scan') {
          steps {
            withSonarQubeEnv('SonarQube') {
              script {
                sh '''
                  echo "🧹 Preparing Sonar cache directory..."
                  mkdir -p .sonar/cache
                  chmod -R 777 .sonar

                  echo "⏳ Waiting for SonarQube to be ready..."
                  for i in {1..10}; do
                    STATUS=$(curl -s http://sonarqube:9000/api/system/status | grep -o '"status":"[A-Z]*"' || true)
                    echo "SonarQube status: $STATUS"
                    if echo "$STATUS" | grep -q '"status":"UP"'; then
                      echo "✅ SonarQube is ready!"
                      break
                    fi
                    sleep 10
                  done

                  echo "🚀 Running SonarScanner in Docker..."
                  docker run --rm \
                    --user root \
                    --network fyp_devnet \
                    --add-host sonarqube:172.18.0.2 \
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
      when {
        branch 'main'
      }
      steps {
        input message: 'Deploy to production?'
      }
    }

    stage('Deploy') {
      steps {
        echo '🚢 Deploying the application...'
        // your deployment logic here
      }
    }
  }

  post {
    failure {
      echo '❌ Pipeline failed.'
    }
    success {
      echo '🟢 Pipeline passed! Let’s gooo.'
    }
  }
}

