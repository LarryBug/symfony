<?php
/**
 * Created by PhpStorm.
 * User: larry
 * Date: 2018/5/21
 * Time: 8:33 PM
 */

namespace LarryBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;


class SendEmailCommand extends ContainerAwareCommand{

    protected function configure()
    {
        $this
            ->setName("larry:send-email")
            //commanQ2A1d: php app/console larry:send-email

            ->setDescription("Send an email.")

            ->setHelp("This command allow you send an email")

            #->addArgument("email",InputArgument::REQUIRED,"The email address")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            "Sending Email:",
            "============",]);

        # $this->sendEmail();
        $this->sendEmailBySwift();

    }

    public function sendEmailBySwift(){

        date_default_timezone_set("Asia/Shanghai");
        $message = (new \Swift_Message("Test PHP Command Email - ".date("Y/m/d H:i:s A")))
            ->setFrom("wl_numberone@163.com")
            ->setTo("lwang@aaxishina.com")
            ->setBody("Test", "text/html");

        if(!$this->getContainer()->get('mailer')->send($message)) {
            echo "Send an email failed!\n".$this->ErrorInfo;
        }
        else {
            echo "Send an email successfully!\n";
        }
    }

    public function sendEmail(){

        // 发送邮件
        include("class.phpmailer.php");
        $mail = new \PHPMailer() ;    //new一个PHPMailer对象，以便操作

        $mail->isSMTP();    //设置SMTP发送
        $mail->Host="smtp.163.com";    //这是服务器邮箱，即上面1中所提到的邮箱地址

        $mail->Port = 25;  //邮件发送端口

        $mail->CharSet="UTF-8";     //设置字符集
        $mail->Encoding = "base64"; //编码方式

        $mail->Username = "wl_numberone@163.com";     //这是你自己的1中所登陆的163邮箱地址
        $mail->SMTPAuth = true;      //设置STMP验证邮箱
        $mail->Password = "********";    //如果SMTPAuth是ture, password要填授权码
        $mail->From = "wl_numberone@163.com";      //这是你自己的1中所登陆的163邮箱地址
        //$mail->FromName = "admin";     //这是发送时你的名字，可随意修改

        $address = "lwang@aaxischina.com" ;
        $mail->AddAddress($address);       //这是你要发给谁，那个人的邮箱地址和他的名字

        date_default_timezone_set("Asia/Shanghai");
        $mail->Subject = "Test PHP command - ".date("Y/m/d H:i:s A") ;;        //这是发送的邮件的主题

        $message = "MSG" ;
        $mail->Body = $message;       //这是发送的邮件的内容

        //$mail->AddAttachment("/Users/larry/PhpstormProjects/Basic/upload/2018 AAXIS Work Calendar.jpg","附件1"); // 添加附件,并指定名称
        //$mail->SMTPDebug=2;

        if(!$mail->Send())    //发送邮件并判断
        {
            echo "Send an email failed!\n".$mail->ErrorInfo;
        }
        else
        {
            echo "Send an email successfully!\n";
        }
    }
}


