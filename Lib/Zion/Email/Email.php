<?php/****    Sappiens Framework*    Copyright (C) 2014, BRA Consultoria**    Website do autor: www.braconsultoria.com.br/sappiens*    Email do autor: sappiens@braconsultoria.com.br**    Website do projeto, equipe e documentação: www.sappiens.com.br*   *    Este programa é software livre; você pode redistribuí-lo e/ou*    modificá-lo sob os termos da Licença Pública Geral GNU, conforme*    publicada pela Free Software Foundation, versão 2.**    Este programa é distribuído na expectativa de ser útil, mas SEM*    QUALQUER GARANTIA; sem mesmo a garantia implícita de*    COMERCIALIZAÇÃO ou de ADEQUAÇÃO A QUALQUER PROPÓSITO EM*    PARTICULAR. Consulte a Licença Pública Geral GNU para obter mais*    detalhes.* *    Você deve ter recebido uma cópia da Licença Pública Geral GNU*    junto com este programa; se não, escreva para a Free Software*    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA*    02111-1307, USA.**    Cópias da licença disponíveis em /Sappiens/_doc/licenca**//** * @author Feliphe "O Retaliador" Bueno - <feliphezion@gmail.com> * @since 24/9/2014 * @version 1.0 * @copyright 2014 *  * Interface para envio de emails através do phpMailer. *  */namespace Zion\Email;class Email{    /**     * PhpMailer::enviarEmail()     *      * @param string $email     * @param string $assunto     * @param string $msg     * @param string $from posição em $SIS_CFG['mailAccounts'] contendo as informações de login no servidor smtp.     * @return bool     */    public function enviarEmail($email, $assunto, $msg, $from)    {        $geral = \Zion\Validacao\Geral::instancia();        if ($geral->validaEmail($email) === false){            throw new \Exception("O Email '". $email ."' é Inválido!");        }        require \SIS_NAMESPACE_FRAMEWORK . '/phpMailer/PHPMailerAutoload.php';        $mail = new \PHPMailer();        $namespace = '\\' . \SIS_ID_NAMESPACE_PROJETO . '\\Config';        $configs = $namespace::$SIS_CFG['mailAccounts'][$from];        $mail->IsSMTP();        $mail->Host = $configs['host'];        $mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)        $mail->Username = $configs['email']; // Usuário do servidor SMTP        $mail->Password = $configs['pass']; // Senha do servidor SMTP        $mail->From = $configs['email']; // Seu e-mail        $mail->FromName = $configs['fromName']; // Seu nome        $mail->AddAddress($email, \SIS_NOME_PROJETO);        $mail->IsHTML(true);        $mail->CharSet = 'UTF-8';                //$mail->SMTPDebug = 1;        if (!empty($configs['secureSmtp'])) {            $mail->Port = $configs['port'];            $mail->SMTPSecure = $configs['secureSmtp'];        }        $mail->Subject = $assunto; // Assunto da mensagem        $mail->Body = $msg;        $Enviado = $mail->Send();        $mail->clearAllRecipients();        if (!$Enviado) {            throw new \Exception('Não foi possivel enviar o e-mail. Tente novamente em instantes. <span style="display: none;">'. $mail->ErrorInfo .'</span>');        }        return true;    }}