<?php
require_once 'Model.php';

class Controller
{
    private $model;
    private $emailSender;
    private $smsSender;
    private $csrfToken;

    public function __construct(Model $model, EmailSender $emailSender, SMSSender $smsSender)
    {
        $this->model = $model;
        $this->emailSender = $emailSender;
        $this->smsSender = $smsSender;
        $this->csrfToken = bin2hex(random_bytes(32));
    }

    public function handleRequest()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!$this->validateCSRFToken()) {
                die('Invalid CSRF token.');
            }

            $content = htmlspecialchars($_POST['content']);

            $id = $this->model->saveFormData($content);

            $savedContent = $this->model->getFormData($id);

            $this->emailSender->sendEmail('test@example.com', 'Form Submission', $savedContent);

            $this->smsSender->sendSMS('+123456789', $savedContent);

            $_SESSION['message'] = 'Form submitted successfully.';

            header('Location: index.php?id=' . $id);
            exit;
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $savedContent = $this->model->getFormData($id);
        }

        $_SESSION['csrf_token'] = $this->csrfToken;

        include 'index_view.php';
    }

    private function validateCSRFToken()
    {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            return false;
        }
        return true;
    }

    public function getCSRFToken()
    {
        return $this->csrfToken;
    }
}
