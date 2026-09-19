/*************************************************************
 * This script is developed by Arturs Sosins aka ar2rsawseen, http://webcodingeasy.com
 * Feel free to distribute and modify code, but keep reference to its creator
 *
 * Skype status class can display your skype status as skype image on your website 
 * and update it automatically using specified update interval. 
 * This class also provides option to use skype functions on displayed status image, 
 * like call, chat, add to contacts, show profile, send voicemail or file.
 *
 * Note that you must enable "Allow my online status to be shown on the web" 
 * in your skype privacy settings, or your status will be shown as offline.
 *
 * For more information, examples and online documentation visit: 
 * http://webcodingeasy.com/JS-classes/Display-skype-status-image-on-your-website
**************************************************************/
var skype_status = function(id, config) {
	this.elem = document.getElementById(id);
	var skype_name = "";
	var user = "";
	this.conf = {
		/***************************************
		* Your skype username
		* Multiple usernames can be provided in array
		* to create multi user chat, conference call, etc
		* but only first user will be used to get online status
		****************************************/
		skype_name: "echo123",
		/***************************************
		* Possible types of images:
		* balloon          - Balloon style 
		* bigclassic       - Big Classic Style 
		* smallclassic     - Small Classic Style 
		* smallicon        - Small Icon (transparent background) 
		* mediumicon       - Medium Icon 
		* dropdown-white   - Dropdown White Background 
		* dropdown-trans   - Dropdown Transparent Background
		****************************************/
		image: "balloon",
		/***************************************
		* Possible types of actions:
		* ""          - Empty, no action. 
		* call        - Call to user
		* chat        - Open chat window
		* add         - Add to skype
		* userinfo    - Open user profile 
		* voicemail   - Leave voicemail (Only if you have voicemail subscription) 
		* sendfile    - Send file to user 
		****************************************/
		action: "",
		//how often to recheck skype status
		update: 10000
	};
	var ob = this;
	this.construct = function(){
		for(var opt in config){
			this.conf[opt]= config[opt];
		}
		if(typeof(this.conf.skype_name) == "object")
		{
			skype_name = this.conf.skype_name[0];
			user = this.conf.skype_name.join(";");
		}
		else
		{
			skype_name = this.conf.skype_name;
			user = this.conf.skype_name;
		}
		//get online status image
		var img = document.createElement('img');
		img.style.borderStyle = "none";
		img.src = "http://mystatus.skype.com/" + this.conf.image + "/" + skype_name + "?rand=" + get_rand();
		if(this.conf.action != "")
		{
			//generate action link
			var a = document.createElement('a');
			a.href = "skype:" + user + "?" + this.conf.action;
			a.appendChild(img);
			this.elem.appendChild(a);
		}
		else
		{
			this.elem.appendChild(img);
		}
		//sent update interval
		if(this.conf.update > 0)
		{
			setInterval(status_update, this.conf.update);
		}
	};
	
	var status_update = function(){
		var img = ob.elem.getElementsByTagName("img");
		img[0].src = "http://mystatus.skype.com/" + ob.conf.image + "/" + skype_name + "?rand=" + get_rand();
	};
	
	var get_rand = function(){
		return Math.round(Math.random()*10000000000);
	};
	
	this.construct();
}