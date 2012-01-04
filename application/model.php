<?php

function get_content()
{
    $home_content = new html('Hello and welcome to my homepage. You will find everything from my academic performance to professional work here. Although my homepage is still in its infancy, I hope you find all the information you need. Feel free to use the tabs above for browsing through the site.');
    $about_me_content = new html('I am currently in the third year of my 5-year B.Tech+M.Tech integrated programme at the Department of Computer Science and Engineering, IIT Kanpur.');
    $my_work_content = new html('You can find my resume ');
    $my_work_content->put('here', 'a', array(
                                    array(
                                        'name' => 'href',
                                        'value' => './Prakhar_Banga_Resume.pdf'
                                        )
                                    )
                         );
    $my_work_content->put('.');
    $some_programs = new html('Here are some things I coded in my spare time which might be interesting to try out:');
    $some_programs->put('newline');
    $progs = new html(new html('Maze game', 'a',
                    array (
                        array('name' => 'href',
                              'value' => array('?script=maze&amp;back=', 'current_page'))
                    )
                    ), 'li');
    $some_programs->put($progs, 'ul');
    $contact_me = new html('You can contact me through e-mail: ');
    $contact_me->put('newline');
    $mails = new html('prakban@iitk.ac.in', 'li');
    $mails->put('prakban@cse.iitk.ac.in', 'li');
    $contact_me->put($mails, 'ul');
    return array(
            'page_title' => 'Prakhar Banga\'s homepage',
            'tabs' => array(
                array(
                    'title' => 'Home',
                    'content' => $home_content
                    ),
                array(
                    'title' => 'About me',
                    'content' => $about_me_content
                    ),
                array(
                    'title' => 'My work',
                    'content' => $my_work_content
                    ),
                array(
                    'title' => 'Some programs',
                    'content' => $some_programs
                    ),
                array(
                        'title' => 'Contact me',
                        'content' => $contact_me
                     )
                    ),
                'modified' => date('F d Y H:i:s', getLastModifiedDate(".")) . " IST(GMT +5:30)"
                    );
}

function getLastModifiedDate($file) {
    if(!is_dir($file)) {
        return filemtime($file);
    } else {
        $list = scandir($file);
        $mod = 0;
        foreach($list as $innerFile) {
            if($innerFile != '.' && $innerFile != '..') {
                $thisMod = getLastModifiedDate($file . '/' . $innerFile);
                $mod = ($mod > $thisMod) ? $mod : $thisMod;
                $thisMod = getLastModifiedDate($file . '/' . $innerFile);
            }
        }
        return $mod;
    }
}


?>
