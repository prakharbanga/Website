<?php

function get_content()
{
    $home_content = new html('Hello and welcome to my homepage. Although it is still in its infancy, I hope you find all the information you need. Feel free to use the tabs above for browsing through the site.');
    $about_me_content = new html('I am currently in the third year of my 5-year B.Tech+M.Tech integrated programme at the Department of Computer Science and Engineering, IIT Kanpur.');
    $about_me_content->put('p');
    $about_me_content->put('I like programming, or things related to programming and I am pleased to see things I programmed that work perfectly. I also like philosophy and criticially examining most things we take for granted and that is why I rapidly change my views on any subject in life. In fact, I like logically thinking about anything and working out new and innovative solutions, whether it is a math problem or a real-life one. I also like swimming as a way to cool down in the summer. And last but not the least, I like people who are like me. :)');
    $my_work_content = new html('You can find my resume ');
    $my_work_content->put('here', 'a', array(
                                    array(
                                        'name' => 'href',
                                        'value' => './Prakhar_Banga_Resume.pdf'
                                        )
                                    )
                         );
    $my_work_content->put('.');
    $some_programs = new html('I will keep updating this list whenever I make something new in my spare time. Until then, you can:');
    $some_programs->put('newline');
    $progs = new html(new html('Play the maze game', 'a',
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
                    'title' => 'Fun stuff',
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
