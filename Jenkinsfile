pipeline {
    agent any

    stages {
        stage('Clone Repository') {
            steps {
                echo '📦 Cloning from GitHub...'
                git branch: 'main',
                    url: 'https://github.com/NivethLegend/supermarket-FYP.git',
                    credentialsId: 'github-creds'
            }
        }

        stage('Build') {
            steps {
                echo '🔧 Running build steps...'
                // Add your build steps like composer install or npm install
            }
        }

        stage('Test') {
            parallel {
                stage('SonarQube Scan') {
                    steps {
                        withCredentials([string(credentialsId: 'sonar-token', variable: 'SONAR_AUTH_TOKEN')]) {
                            withSonarQubeEnv('SonarQube') {
                                sh '''
                                    -e SONAR_HOST_URL=http://sonarqube:9000 \
                                    -e SONAR_TOKEN=$SONAR_AUTH_TOKEN \
                                    -v "$PWD:/usr/src" \
                                    -v "$PWD/.scanner_cache:/opt/sonar-scanner/.sonar/cache" \
                                    sonarsource/sonar-scanner-cli \
                                    -Dsonar.projectKey=supermarket \
                                    -Dsonar.sources=. \
                                    -Dsonar.working.directory=.scannerwork
                                '''
                            }
                        }
                    }
                }

                stage('Dummy API Test') {
                    steps {
                        echo '🧪 Running dummy API test...'
                        // curl or echo "API test" command here
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
                echo '🚀 Deploying application...'
                sh '''
                    docker compose down
                    docker compose build
                    docker compose up -d
                '''
            }
        }
    }

    post {
        success {
            echo '✅ Pipeline completed successfully.'
        }
        failure {
            echo '❌ Pipeline failed.'
        }
    }
}

