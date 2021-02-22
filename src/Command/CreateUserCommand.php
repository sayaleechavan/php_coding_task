<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Service\DateTimeService;
use Symfony\Component\Console\Question\Question;
use DateTime;
use Symfony\Component\Console\Helper\Table;


class CreateUserCommand extends Command
{


    protected function configure()
    {

        // the short description shown while running "php bin/console list"
        $this->setName('Pepper-Employee')
            ->setDescription('Returns employee vacation days')
            ->setHelp('Demonstration of custom commands created by Symfony Console component.');

        $this
                 ->addArgument('year', InputArgument::REQUIRED, 'Please enter the year.');
            
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
            
            
            
            $default = '2021';
            // $helper = $this->getHelper('question');
            // $question = new Question('Please enter the year: ', $default);

            // $inp_year = $helper->ask($input, $output, $question);
            $inp_year =  $input->getArgument('year');
            $input = new DateTime(date("Y", strtotime($inp_year. '-01-01')));
            

            $array = array(array('name'=> 'Dominik Muller', 'DOB'=> '30.12.1950' , 'Con_St_dt' => '01.01.2001' ,  'Special_contract' => ''),
                          array('name'=> 'Angelika Fringe', 'DOB'=> '09.06.1966' , 'Con_St_dt' => '15.01.2001' ,  'Special_contract' => ''),
                          array('name'=> 'Stefan Bernards', 'DOB'=> '12.07.1991' , 'Con_St_dt' => '15.05.2016' ,  'Special_contract' => '27'),
                          array('name'=> 'Brigitte Wirtz', 'DOB'=> '26.01.1971' , 'Con_St_dt' => '15.01.2018' ,  'Special_contract' => ''),
                          array('name'=> 'Sepp Borchardt', 'DOB'=> '23.05.1980' , 'Con_St_dt' => '01.12.2017' ,  'Special_contract' => ''),
                        );

                        $table = new Table($output);
                        $table->setHeaderTitle('Peppers Vacation Days');
                        $table->setHeaders(['Name', 'Vacation Days']);

                        
                        foreach($array as $key => $value)
                        {
                            $vacation_days = 26;
                            $default_vacation = 26;
                            $name = $value['name'];
                            $special_contract = $value['Special_contract'];
                            $DOB =  new DateTime(date("Y-m-d", strtotime($value['DOB'])));

                            
                            $contract_start = new DateTime(date('Y', strtotime($value['Con_St_dt'])));
                            $contract_start_year = date('Y', strtotime($value['Con_St_dt']));
                            
                            $employee_age = $DOB->diff($input)->y;

                            $contract_start_vac = 12 - date('m', strtotime($value['Con_St_dt'])) ;
                            
                            $experince = $inp_year - $contract_start_year;

                            if($inp_year >= $contract_start_year )
                            {
                                
                                if($inp_year == $contract_start_year )
                                {
                                    

                                    $vacation_days = round($default_vacation/12 * $contract_start_vac);
                                
                                    
                                }
                                elseif ($special_contract != '')
                                {
                                    $vacation_days = $special_contract;
                                   
                                
                                
                                }

                                elseif($employee_age >= 30)
                                {
                                    
                                    // dump($experince);
                                    // dump($vacation_days);
                                    if($experince % 5 == 0)
                                    {
                                        
                                        $vacation_days = $vacation_days + 1;
                                       
                                        
                                    }
                                    else
                                    {
                                        $vacation_days = $default_vacation;
                                    }
                                    
                                }
                                
                            }
                            
                            else
                            {
                                $vacation_days = 0;
                            }
                           
                            $tab[] = [$name, $vacation_days];
                            
                        }
        
                        $table->setRows($tab);
                       
                
                        $table->render();

        return 1;
    }
}