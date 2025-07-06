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
                                    echo "🧹 Preparing Sonar cache directory..."
                                    mkdir -p .sonar/cache
                                    chmod -R 777 .sonar

                                    echo "🚀 Running SonarScanner in Docker..."
                                    docker run --rm \
                                        --user root \
                                        --network fyp_devnet \
                                        -e SONAR_HOST_URL=http://172.18.0.2:9000
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

