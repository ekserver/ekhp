<!DOCTYPE html>
<html>

    <head>
        {head:head}
    </head>

<body>
    {header:header}

    <div id="wrapper">
    	
    	<div id="server-status">
    		{serverstatus:serverstatus}
    	</div>
    
        <div id="content-container">
        	<div id="title">
            	<h1>{title}</h1>
        	</div>
            <div id="content">
            	{content:content}
            </div>
            <div id="foot"></div>
        </div>
        
        <div id="sidebar">
        	<div class="box">
        		<h3>Serverinformationen</h3>
        		<div class="content">
        			{module:serverinfo}
        		</div>
        	</div>
        	<div class="box">
        		<h3>Events</h3>
        		<div class="content">
        			{module:events}
        		</div>
        	</div>
        	<div class="box">
        		<h3>Forumaktivit&auml;t</h3>
        		<div class="content">
        			{module:forum_activity}
        		</div>
        	</div>
        </div>
        
        <div id="footer-container">
            <div id="footer">{footer:footer}</div>
        </div>
    </div>

</body>
</html>