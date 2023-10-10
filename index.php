<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/html/styles/index.css">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
        <input id="searchBar" class="searchBar" placeholder="Search someone or something..."/>
        <?php
            function add_post($name,$post_content) {
                echo '<div class="categRect">' . $name . ' : ' . $post_content . '</div>';
            }
        ?>
        <div class="categWindow">
            <p><span> CATEGORIES </span></p>
            <?php
                add_post('@Un','Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Morbi sem diam, molestie a convallis non, ullamcorper vitae velit.');
                add_post('@Deux','Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Morbi sem diam, molestie a convallis non, ullamcorper vitae velit.');
                add_post('@Trois','Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Morbi sem diam, molestie a convallis non, ullamcorper vitae velit.');
                add_post('@Quatre','Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Morbi sem diam, molestie a convallis non, ullamcorper vitae velit.');
                add_post('@Cinq','Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Morbi sem diam, molestie a convallis non, ullamcorper vitae velit.');
                add_post('@Six','Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Morbi sem diam, molestie a convallis non, ullamcorper vitae velit.');
                add_post('@Sept','Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Morbi sem diam, molestie a convallis non, ullamcorper vitae velit.');
                add_post('@Huit','Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Morbi sem diam, molestie a convallis non, ullamcorper vitae velit.');
                add_post('@Neuf','Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Morbi sem diam, molestie a convallis non, ullamcorper vitae velit.');
                add_post('@Dix','Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Morbi sem diam, molestie a convallis non, ullamcorper vitae velit.');
            ?>
        <div/>
    </body>
</html>
