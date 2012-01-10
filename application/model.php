<?php

function get_content()
{
    $home_content = new html();
    $about_me_content = new html();
    $my_work_content = new html();
    $some_programs_content = new html();
    $contact_me_content = new html();

    $hello = new html('Hello and welcome to my homepage. Although it is still in its infancy, I hope you find all the information you need. Feel free to use the tabs above for browsing.');
    
    $home_content->put($hello, 'p');

    $college = new html('I am currently in the third year of my 5-year B.Tech+M.Tech integrated programme at the Department of Computer Science and Engineering, IIT Kanpur.');
    $hobbies = new html('I like programming and I am pleased to see things I programmed that work perfectly. I also like philosophy and criticially examining most things we take for granted and that is why I rapidly change my views on any subject in life. In fact, I like logically thinking about anything and working out new and innovative solutions, whether it is a math problem or a real-life one. Occasionally I like to swim, skate and watch interesting documentaries or shows related to science, technology or the environment.');

    $about_me_content->put($college, 'p');
    $about_me_content->put($hobbies, 'p');

    $proj_outer = new html('My major projects include:');
    $proj_list = new html();

    $aurus_android = new html('Content Management System for Android:', 'strong');
    $aurus_android->put('newline');
    $aurus_android->put('May-July 2011', 'em');
    $aurus_android->put('newline');
    $aurus_android->put('The project involved designing the workflow and implementing from scratch ');
    $aurus_android->put('Aurus', 'a', array(
                                array('name' => 'href',
                                      'value' => 'http://www.aurusnet.com')
                              ));
    $aurus_android->put('\'s Content Management System application for the Android 2.2(Froyo) platform, an application basically meant to be distributed for easy access to study material such as video lectures, quizzes and notes, on Android tablets.');
    $aurus_android->put('newline');
    $aurus_android->put('Project supervisor: Mr. Sujeet Kumar, VP Engineering, Aurus Network Infotech Pvt. Ltd.', 'em');


    $aurus_flex = new html('Bookmarks Component for Flex(Flash) application:', 'strong');
    $aurus_flex->put('newline');
    $aurus_flex->put('May 2011', 'em');
    $aurus_flex->put('newline');
    $aurus_flex->put('The project involved first designing an interactive component for the ');
    $aurus_flex->put('Aurus Video Client', 'a',
                    array(array('name' => 'href',
                                'value' => 'http://www.aurusnet.com/index.php?r=site/page&amp;view=livestudios')));
    $aurus_flex->put(' using Flash Builder platform, and then incorporating it in the existing video client.');
    $aurus_flex->put('newline');
    $aurus_flex->put('Project supervisor: Mr. Sujeet Kumar, VP Engineering, Aurus Network Infotech Pvt. Ltd.', 'em');

    $proj_list->put($aurus_android, 'li');
    $proj_list->put($aurus_flex, 'li');

    $proj_outer->put($proj_list, 'ul');

    $resume = new html('Projects done as a part of a course/otherwise can be found in my resume ');
    $resume->put('here', 'a', array(
                                    array(
                                        'name' => 'href',
                                        'value' => './Prakhar_Banga_Resume.pdf'
                                        )
                                    )
                         );
    $resume->put('.');

    $research_interests = new html('My major areas of interest include programming languages especially the Object-oriented ones like Java, Ruby and Smalltalk; analysis of programs; object-oriented methods of software construction(like the MVC pattern, which this site uses) and methods like refactoring of code.');

    $my_work_content->put($proj_outer);
    $my_work_content->put($resume, 'p');
    $my_work_content->put($research_interests, 'p');

    $progs = new html('I will keep updating this list whenever I make something new in my spare time. Until then, you can:');
    $progs->put('newline');
    $progs_list = new html();
    $progs_list->put(new html('Play the maze game', 'a',
                    array (
                        array('name' => 'href',
                              'value' => array('?script=maze&amp;back=', 'current_page'))
                    )
                    ), 'li');
    $progs->put($progs_list, 'ul');
    $some_programs_content->put($progs);

    $email = new html('You can contact me through e-mail: ');
    $email->put('newline');
    $mails = new html();
    $mails->put('prakban@iitk.ac.in', 'li');
    $mails->put('prakban@cse.iitk.ac.in', 'li');
    $email->put($mails, 'ul');

    $contact_me_content->put($email);

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
                    'content' => $some_programs_content
                    ),
                array(
                    'title' => 'Contact me',
                    'content' => $contact_me_content
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
