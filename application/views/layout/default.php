<!DOCTYPE html>
<html>

    <head>
        {head:head}
    </head>

<body>
    {header:header}

    <div id="wrapper">
        <div id="content-container">
            <div id="content">
            	<h1><?php echo $title;?></h1>
            	{content:content}
            </div>
        </div>
        
        <div id="footer-container">
            <div id="footer">{footer:footer}</div>
        </div>
    </div>

</body>
</html>