pipeline {
    agent any

    environment {
        DOCKER_IMAGE = 'olyfaneva/back'
        DOCKER_TAG = 'latest'
        REPO_URL = 'https://github.com/OlyFaneva/ProjetFullPHP.git'
        // SMTP_HOST = 'smtp.gmail.com'
        // SMTP_PORT = '587'
        // SMTP_USER = 'olyrarivomanana.com'
        // SMTP_PASS = 'tkbnzycggxoskhwa'
        // }

    stages {
        // Étape 1: Cloner le dépôt Git
        stage('Clone Repository') {
            steps {
                script {
                    echo "Cloning repository: ${REPO_URL}"
                    git url: "${REPO_URL}", branch: 'main'
                }
            }
        }

        // Étape 2: Construire l'image Docker
        stage('Build Docker Image') {
            steps {
                script {
                    echo "Building Docker image: ${DOCKER_IMAGE}:${DOCKER_TAG}"
                    sh "docker build -t ${DOCKER_IMAGE}:${DOCKER_TAG} ."
                }
            }
        }

        stage('Scan Docker Image') {
            steps {
                script {
                    echo 'Scanning Docker image for vulnerabilities'
                    sh '''
                trivy image ${DOCKER_IMAGE}:${DOCKER_TAG} || exit 1
            '''
                }
            }
        }

        // Étape 3: Pousser l'image Docker vers Docker Hub
        stage('Push to Docker Hub') {
            steps {
                script {
                    echo 'Pushing Docker image to Docker Hub'
                    withDockerRegistry([credentialsId: 'docker', url: 'https://index.docker.io/v1/']) {
                        sh "docker push ${DOCKER_IMAGE}:${DOCKER_TAG}"
                    }
                }
            }
        }

        stage('Run Ansible Playbook') {
            steps {
                script {
                    echo 'Running Ansible playbook'
                    sh '''
                        ansible-playbook -i hosts.ini deploy.yml
                    '''
                }
            }
        }
    }

    post {
        always {
            echo 'Pipeline finished'
        }
        success {
            echo 'Pipeline succeeded'
        }
        failure {
            echo 'Pipeline failed'
        }

        // always {
        //         script {
        //             def buildStatus = currentBuild.currentResult

        //             emailext(
        //             subject: "Pipeline ${env.JOB_NAME} - Build ${env.BUILD_NUMBER} : ${buildStatus}",
        //             body: """
        //             Bonjour,

        //             Voici les détails de l'exécution du pipeline :

        //             - **Nom du Job** : ${env.JOB_NAME}
        //             - **Numéro du Build** : ${env.BUILD_NUMBER}
        //             - **Statut du Build** : ${buildStatus}
        //             - **URL du Build** : ${env.BUILD_URL}

        //             Merci,
        //             L'équipe Jenkins
        //             """,
        //             to: 'olyrarivomanana@gmail.com',
        //             mimeType: 'text/html',
        //             replyTo: 'no-reply@gmail.com'
        //         )
        //         }
        // }
    }
}
