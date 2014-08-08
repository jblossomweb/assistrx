Developer Notes
=========

This is a step-by-step guide, outlining my approach to this project.
I run Ubuntu 14 on my laptop, where I already have a running apache2/mysql/php5 stack.

I am also keeping track of this project with GitHub and JIRA Agile:

https://github.com/jblossomweb/assistrx/

https://github.com/jblossomweb/assistrx/tree/dev

https://jbzzle.atlassian.net/browse/ARX/

=========

###1. Downloaded supplied codebase, initialized repository

First, I needed to download the file, and put the contents in my web root.

* Unzipped the file `AssistRx-Test.zip`
* Copied its contents to `/var/www/html/assistrx`
* Performed a `git init` locally
* created a public repo origin on GitHub: https://github.com/jblossomweb/assistrx
* added all files as initial commit, pushed local repo to origin (GitHub)

###2. Created and enabled site for Apache, local clients as `local.arxtest.com`

Next, to make life easier, I created a local site for dev purposes.

* Created config: `vim /etc/apache2/sites-available/local.arxtest.com.conf`:

```sh
<VirtualHost *:80>
    <Directory "/var/www/html/assistrx">
        Options Indexes FollowSymLinks MultiViews
        AllowOverride all
        Order allow,deny
        Allow from all
    </Directory>
    DocumentRoot "/var/www/html/assistrx"
    ServerName local.arxtest.com
    ServerAlias local.arxtest.com
    ErrorLog "/var/log/apache2/assistrx-error.log"
</VirtualHost>
```

* Enabled the newly configured site: `a2ensite local.arxtest.com`
* Restarted apache: `sudo service apache2 restart`
* Bypassed DNS on local by adding to host file `sudo vim /etc/hosts`:

```sh
192.168.X.X	local.arxtest.com
```

* Added same line to Windows 7 client I use on same network for IE 8/9 testing. (`C:\Windows\System32\drivers\etc
hosts`)

###3. Configured local database settings for dev

Next I had to connect the database.

* created a local mysql database schema: `arx_test`
* created a local mysql database user, with permission to schema: `arxtest`
* ran the dump file supplied with project.
* navigated to project webroot: `cd  /var/www/html/assistrx`
* copied sample file: `cp config/database.sample.php config/database.php`
* changed settings to reflect host, schema, user, and password.
* created a `.gitignore` file in the project webroot, containing `config/database.php`
* test by hitting `patients.php` in a web browser.

At first, I received an error, and quickly realized the db password cannot contain parenthesis.
I had used a secure password generator. I generated a new password for the db user without parenthesis, and made the code change to `config/database.php`

* Upon successful render of http://local.arxtest.com/patients.php I added the .gitignore, committed and pushed.

###4. Branched for dev, created markdown file for notes

Next I created a development branch, then committed this file.

* Navigated to project webroot: `cd /var/www/html/assistrx`
* Created a local branch called 'dev': `git checkout -b dev`
* Created a markdown file for notes: `vim developer_notes.md`
* Added to repo: `git add developer_notes.md`
* Committed: `git commit -am 'developer notes'`
* Pushed new branch to GitHub: `git push origin dev`

###5. Installed CodeIgniter MVC framework

At this point, since it was allowed, I decided that I wanted to take the time to overhaul the entire project.

I had built an admin panel with a really nice skin and ajax sub-framework into <a href="https://ellislab.com/codeigniter">CodeIgniter</a> for a previous project.
I figured this would bring the needed bells and whistles, and show off the portability of previously written classes.

First, I wanted to isolate and preserve the legacy codebase:

* Navigated to project webroot: `cd /var/www/html/assistrx`
* Created directory 'legacy': `mkdir legacy`
* Copied all existing files into legacy.

Next, I installed CodeIgniter:

* Downloaded a fresh copy of version 2.2 from <a href="https://ellislab.com/codeigniter">https://ellislab.com/codeigniter</a>
* Unzipped into `/var/www/html/assistrx`
* Added to repo: `git add *`
* Committed: `git commit -am 'preserve legacy app, init codeigniter'`
* Pushed branch to GitHub: `git push`

###6. Cleaned the URL

CodeIgniter's front controller is index.php, and one can mask this to make nice, pretty, REST-like URLs.
I used the standard .htaccess for this.

* Navigated to project webroot: `cd /var/www/html/assistrx`
* Created file '.htaccess': `vim .htaccess`

```sh
+Options +FollowSymLinks
+Options +Indexes
+RewriteEngine On
+RewriteCond %{REQUEST_FILENAME} !-f
+RewriteCond %{REQUEST_FILENAME} !-d
+RewriteCond $1 !^(index\.php|images|robots\.txt)
+RewriteRule ^(.*)$ index.php/$1 [L]
```

* add to repo: `git add .htaccess`
* commit: `git commit -am 'htaccess to clean index.php from url'`
* Pushed branch to GitHub: `git push`

###7. Integrate Devoops skin, and my Admin platform

Next, I ported over the controllers, model classes, views, and css/js from the Admin platform that I had built previously, using a skin provided by Devoops.

Credit for the theme: https://github.com/devoopsme/devoops/

* the theme resides in `/var/www/html/assistrx/assets/devoops`
* I added my code files and edited them as necessary:

```sh
application/config/autoload.php
application/config/config.php
application/config/constants.php
application/config/database.example.php
application/config/database.php
application/config/email.example.php
application/controllers/admin.php
application/controllers/cli.php
application/controllers/cli/cli_admin.php
application/core/MY_Loader.php
application/core/MY_Router.php
application/libraries/Artools.php
application/libraries/Base.php
application/libraries/Password.php
application/models/admin/admin_admin_user_model.php
application/models/admin/admin_ajax_model.php
application/models/admin/admin_login_model.php
application/third_party/MX/Base.php
application/third_party/MX/Ci.php
application/third_party/MX/Config.php
application/third_party/MX/Controller.php
application/third_party/MX/Lang.php
application/third_party/MX/Loader.php
application/third_party/MX/Modules.php
application/third_party/MX/Router.php
application/views/admin/dashboard.php
application/views/admin/devoops.php
application/views/admin/index.html
application/views/admin/login.php
application/views/admin/templates.php
application/views/admin/templates/blocks/cancel-submit.php
application/views/admin/templates/blocks/guts-loader.php
application/views/admin/templates/breadcrumbs.php
application/views/admin/templates/fields/number.php
application/views/admin/templates/fields/text.php
application/views/admin/templates/index.html
application/views/email/boilerplate.php
application/views/email/index.html
application/views/email/new_admin_user.php
application/views/email/new_admin_user_plain.php
assets/css/admin/font.css
assets/css/admin/style.css
assets/fonts/MyriadPro-Regular.otf
assets/images/admin/pbar-ani.gif
assets/images/admin/thumbs/donkeykong.png
assets/images/admin/thumbs/flower.png
assets/images/admin/thumbs/mario.png
assets/images/admin/thumbs/megaman.png
assets/images/admin/thumbs/qbert.png
assets/images/logo.png
assets/images/logo_w.png
assets/js/admin/dashboard.js
assets/js/admin/devoops-constants.js
assets/js/admin/guts-form.js
assets/js/admin/guts-global.js
assets/js/admin/guts-list.js
assets/js/admin/login.js
assets/js/handlebars-v1.3.0.js
assets/js/jquery.form.js
assets/js/jquery.form.min.js
env.php
favicon.ico
index.php
sh/newadmin.sh
```

I did this all at once, along with other steps, so the commit was huge:
https://github.com/jblossomweb/assistrx/commit/7149d2f475d5b60f1ace924fa35537962e47cdfb


###8. Build DB support for admin log in/out, with command-line user generation

In order for my admin panel to work, I had to add the corresponding DB table, and get the script to work.

* I ran the following SQL against the `arx_test` schema, and saved the SQL in a file `db2.sql`:

```sql
CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(1024) NOT NULL,
  `password` varchar(1024) NOT NULL,
  `pwkey` varchar(255) NOT NULL,
  `email` varchar(1024) NOT NULL,
  `fname` varchar(45) NOT NULL,
  `lname` varchar(45) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;

```

* Next, I needed to make some changes to the controllers and specifically `application/models/admin/admin_login_model.php` 
* I generated a new 'pepper' string to go with the salt/hash, and put it into `application/config/constants.php`
* Once this was setup, admin users can be created using the command-line script: `sh/newadmin.sh`
* I ran the script, to create a user for myself: `bash sh/newadmin.sh`
* Now I have a user named `jblossom` on my local db, with a secure, one-way hashed password (sha256 instead of md5, this requires apache mcrypt, installed via pecl I believe )


###9. Patients List Page

Now that I could log in, I was ready to re-create the patients list page onto the admin panel.

* First, I added the menu item html to the outer devoops template (hardcoding for now, not building a dynamic menu):

```sh
vim application/views/admin/devoops.php
```

```html
<li class="dropdown">
	<a class="dropdown-toggle" style="cursor:pointer;">
		<i class="fa fa-users"></i>
		<span class="hidden-xs">Patients</span>
	</a>
	<ul class="dropdown-menu">
		<li>
            <a class="ajax-link" href="/admin/ajax/patients">
                <i class="fa fa-list"></i>
                <span class="hidden-xs">List</span>
            </a>
        </li>
	</ul>
</li>

```

* Next, I added a 'patients' method to the admin ajax model (loaded via convention from ajax controller):

```sh
vim application/model/admin_ajax_model.php
```

```php
	public function patients($sub='list'){
		$this->load->model('admin/entity/admin_patient_model','patient');
		switch($sub){
			case 'add':
			break;
			case 'edit':
			break;
			case 'list':
			default:
				$patients = $this->patient->list_all();
				$data = array(
					'patients'	=>	$patients,
				);
		}
		return $data;
	}
```

* Then I added the admin patient entity model, with the referenced list_all method:


```sh
vim application/models/admin/entity/admin_patient_model.php
```

```php
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_patient_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function list_all(){
		$this->db->select('
			patient_id as id, 
			patient_name as name, 
			patient_phone as phone, 
			patient_age as age, 
			favorite_song_id as song_id
		');
		$patients = $this->db->get('patients');
		$patients = $patients->result_array();
		return $patients;
	}
	
}
```

* Finally, I added the necessary view file, also called by convention from the admin ajax controller:

```sh
vim application/views/admin/pages/patients/list.php
```

```html
<!--Start Breadcrumb -->
<div id="breadcrumbs-container"></div>
<!--End Breadcrumb-->
<?php $this->load->view('admin/templates/blocks/guts-loader');?>
<div class="row" id="guts" style="display:none;">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-users"></i>
					<span>Patient Listing</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<a class="expand-link">
						<i class="fa fa-expand"></i>
					</a>
					<a class="close-link">
						<i class="fa fa-times"></i>
					</a>
				</div>
				<div class="no-move"></div>
			</div>

			<div class="box-content no-padding table-responsive">
				<table class="table patients table-bordered table-striped table-hover table-heading table-datatable" id="datatable-2">
					<thead>
						<tr>
							<th><label><input type="text" name="search_name" value="name" class="search_init" /></label></th>
							<th><label><input type="text" name="search_age" value="age" class="search_init" /></label></th>
							<th><label><input type="text" name="search_phone" value="phone" class="search_init" /></label></th>
							<th><label><input type="text" name="search_has_song" value="has song" class="search_init" /></label></th>
							<th>action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($patients as $patient): ?>
						<tr id="patients_<?php echo $patient['id']; ?>" class="patient">
							<td><i class="fa fa-user"></i>&nbsp;<?php echo $patient['name']; ?></td>
							<td><?php echo $patient['age']; ?></td>
							<td><i class="fa fa-phone"></i>&nbsp;<?php echo $patient['phone']; ?></td>
							<td>
								<?php if(intval($patient['song_id']) > 0): ?>
									<span style="display:none">1 yes true <?php echo $patient['song_id']; ?></span><i class="fa fa-check" style="color:green;"></i>
								<?php else: ?>
									<span style="display:none">0 no false</span><i class="fa fa-times" style="color:red;"></i>
								<?php endif;?>
							</td>
							<td>
								<a alt="edit" title="edit" style="cursor:pointer;" onclick="LoadAjaxContent('/admin/ajax/patients/edit?id=<?php echo $patient['id']; ?>');"><i class="fa fa-edit"></i></a>
								<?php /*
								&nbsp;&nbsp;
								<a style="cursor:pointer;" onclick="deleteRecord('patients',<?php echo $patient['id']; ?>);"><i class="fa fa-times"></i></a>
								*/ ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5"><a class="btn btn-primary btn-large" style="cursor:pointer;" onclick="LoadAjaxContent('/admin/ajax/patients/add');"><i class="fa fa-plus"></i> Add New</a></td>
						</tr>
					</tfoot>
				</table>
			</div>

		</div>
	</div>
</div>

<div style="height: 40px;"></div>
<script type="text/javascript">
$(document).ready(function() {
	$.getScript('/assets/js/admin/guts-global.js', function(){
		// load breadcrumbs
		loadCrumbs([
		    {page: "patients", title: "Patients"}
		 ]);
		$.getScript('/assets/js/admin/guts-list.js', function(){
			// Load Datatables and run plugin on tables 
			LoadDataTablesScripts(AllTables);
			// Add Drag-n-Drop feature
			WinMove();
		});
	});		
});
</script>

```

With this, there was now a working patients list page, pulling from the database.

###10. Add new patient

Although it wasn't a requirement, I thought it would be a nice touch.
I had some existing code that was easily repurposed.

* First, I added the menu item html to the outer devoops template, nested under 'Patients':

```sh
vim application/views/admin/devoops.php
```

```html
<li>
    <a class="ajax-link" href="/admin/ajax/patients/add">
        <i class="fa fa-plus"></i>
        <span class="hidden-xs">Add New</span>
    </a>
</li>

```
* Next, I built out the 'add' condition within the 'patients' method in the admin ajax model:

```sh
vim application/model/admin_ajax_model.php
```

```php
case 'add':
	// true indicates XSS filter
	$patient = $this->input->post(null,TRUE);
	if($patient){
		$patient['id'] = $this->patient->insert($patient);
		$data = array(
			'return'	=>	json_encode($patient),
			'form'		=>	false,
		);
	} else {
		$data = array(
			'form'		=>	true,
		);
	}
break;

```

* Then I added the 'insert' and '_validate' methods to the admin patient entity model:


```sh
vim application/models/admin/entity/admin_patient_model.php
```

```php
public function insert($data){
	$data = $this->_validate($data);
	if($data){
		$this->db->insert('patients', array(
			'patient_name'	=>	$data['name'],
			'patient_age'	=>	$data['age'],
			'patient_phone'	=>	$data['phone'],
		)); 
		return $this->db->insert_id();
	}
	return false;
}

```
```php
private function _validate($data){
	extract($data);
	if(empty($name) || !preg_match('/^[a-zA-Z0-9_\.\- ]+$/',$name)){
		//error_log("bad name");
		return false;
	}
	if(empty($age) || !preg_match('/^[0-9]+$/',$age)){
		//error_log("bad age");
		return false;
	}
	if(empty($phone) || !preg_match('/^[0-9\-]+$/',$phone)){
		//error_log("bad phone");
		return false;
	}
	return $data;
}
```

* Now I needed a form. Since it was to be later shared with the edit page, I built it as a dynamically-served handlebars template (weird, I know. It was late at night):

```sh
vim application/views/admin/pages/patients/form.php
```

```html
{{#if patient.id}}
<input class="hidden" name="id" value="{{patient.id}}" />
{{/if}}
<fieldset class="patient-form">
	<legend>Patient Info</legend>
	<?php $this->load->view('admin/templates/fields/text',array(
		'label'	=>	"Patient Name",
		'name'	=>	"name",
		'value'	=>	"{{patient.name}}",
		'icon'	=>	"fa-user",
	));?>
	<?php $this->load->view('admin/templates/fields/number',array(
		'label'	=>	"Age",
		'name'	=>	"age",
		'value'	=>	"{{patient.age}}",
		'icon'	=>	"fa-calendar",
	));?>
	<?php $this->load->view('admin/templates/fields/text',array(
		'label'	=>	"Phone",
		'name'	=>	"phone",
		'value'	=>	"{{patient.phone}}",
		'icon'	=>	"fa-phone",
	));?>
</fieldset>
<?php $this->load->view('admin/templates/blocks/cancel-submit');?>
```

```sh
vim application/views/admin/templates/fields/text.php
```

```html
<div class="form-group locking <?php echo $name; ?> has-feedback">
	<label class="col-sm-3 control-label"><i class="fa fa-unlock"></i>&nbsp;<?php echo $label; ?></label>
	<div class="col-sm-5">
		<input type="text" class="form-control" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
		<span class="fa <?php echo $icon; ?> form-control-feedback"></span>
	</div>
</div>
```

```sh
vim application/views/admin/templates/fields/number.php
```

```html
<div class="form-group locking <?php echo $name; ?> has-feedback">
	<label class="col-sm-3 control-label"><i class="fa fa-unlock"></i>&nbsp;<?php echo $label; ?></label>
	<div class="col-sm-5">
		<input type="number" class="form-control" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
		<span class="fa <?php echo $icon; ?> form-control-feedback"></span>
	</div>
</div>
```

```sh
vim application/views/admin/templates/blocks/cancel-submit.php
```

```html
<div class="form-group">
	<div class="col-sm-9 col-sm-offset-3">
		<button class="btn btn-danger cancel"><i class="fa fa-undo"></i> Go Back</button>
		<button type="submit" class="btn btn-success submit"><i class="fa fa-save"></i> Save</button>
		<i class="fa fa-spinner fa-spin" style="display:none;"></i>
	</div>
</div>
```

* Next, I built the client-side validation script. Even though it is javascript, I decided to load it as a view, to keep the patients stuff in the same folder, and establish that as convention.

```sh
vim application/views/admin/pages/patients/validate.php
```
Notice the regexes should match the corresponding server-side validation from above `_validate()`

```html
<script type="text/javascript">
var validatePatient = function(){
	var form = $(form_selector);
	var inputs = $(form_selector+" :input");
	var btn = $(form_selector+' button.submit');
	var cancel = $(form_selector+' button.cancel');
	var spinner = $(form_selector+' .fa-spin');
	var song = $(form_selector+' button.song');
	var pid = $(form_selector+' :input[name=id]').val();

	cancel.click(function(e){
		e.preventDefault();
		LoadAjaxContent('/admin/ajax/patients');
	});

	song.click(function(e){
		e.preventDefault();
		LoadAjaxContent('/admin/ajax/patients/song?id='+pid);
	});

	form.bootstrapValidator({
		message: 'This value is not valid',
		fields: {
			name: {
				message: 'Please enter a valid Patient Name',
				validators: {
					notEmpty: {
						message: 'The Patient Name is required and cannot be empty'
					},
					stringLength: {
						min: 1,
						max: 50,
						message: 'The Patient Name must be between 1-50 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z0-9_\.\- ]+$/,
						message: 'No special characters, please. Letters, Numbers, Space, Dot, Dash or Underscore'
					}
				}
			},
			phone: {
				message: 'Please enter a valid Patient Phone',
				validators: {
					notEmpty: {
						message: 'The Patient Phone is required and cannot be empty'
					},
					phone: {
						message: 'Please enter a valid phone number (XXX-XXX-XXXX)'
					},
					regexp: {
						regexp: /^[0-9\-]+$/,
						message: 'Numbers and dashes only'
					}
				}
			},
			age: {
				message: 'Please enter a valid Age',
				validators: {
					notEmpty: {
						message: 'The Age is required and cannot be empty'
					},
					integer: {
						message: 'Numbers only' 
					},
					regexp: {
						regexp: /^[0-9]+$/,
						message: 'Numbers only'
					}
				}
			}
			
		},
		submitHandler: function(){
			inputs.prop("disabled", true);
			spinner.show();
			form.ajaxSubmit({
				data: {
					id: 		form.find(":input[name='id']").val(), 
					name: 		form.find(":input[name='name']").val(), 
					age: 		form.find(":input[name='age']").val(),
					phone: 		form.find(":input[name='phone']").val(),  
				},
				success: function(data) { 
					//console.log(data);
					data = $.parseJSON(data);
			        //console.log(data);
			        spinner.hide();
			        //form.fadeOut("fast");
			        LoadAjaxContent('/admin/ajax/patients/edit?id='+data.id);
			        //LoadAjaxContent('/admin/ajax/patients');
			    }
		    });
		}
	}); 
};
</script>
```

* Now that the form was in place, I could use it to build the add patient page:

```sh
vim application/views/admin/pages/patients/add.php
```

```html
<?php if(!$form):?>
<?php echo $return; ?>
<?php else: ?>
<!--Start Breadcrumb -->
<div id="breadcrumbs-container"></div>
<!--End Breadcrumb-->
<div class="row">
	<div class="col-xs-12 col-sm-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-user"></i>
					<span>Add New Patient</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<a class="expand-link">
						<i class="fa fa-expand"></i>
					</a>
					<a class="close-link">
						<i class="fa fa-times"></i>
					</a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content">
				<form id="frmAddPatient" method="post" action="/admin/ajax/patients/add" class="form-horizontal"></form>
			</div>
		</div>
	</div>
</div>

<script id="patient-form-template" type="text/x-handlebars-template">
<?php $this->load->view('admin/pages/patients/form');?>
</script>
<?php $this->load->view('admin/pages/patients/validate');?>

<script type="text/javascript">
var form_selector = "#frmAddPatient";
var form_template = "#patient-form-template";
var form_data = {
	  <?php if(!empty($patient['name'])): ?>,
	  patient: {
	  	name: "<?php echo $patient['name'];?>"
	  }<?php endif;?>
};
$(document).ready(function() {
	$.getScript('/assets/js/admin/guts-global.js', function(){
		// load breadcrumbs
		loadCrumbs([
		    {page: "patients", title: "Patients"},
	    	{page: "patients/add", title: "Add New"}
		 ]);
		renderTemplate(form_template,form_selector,form_data);
		$.getScript('/assets/js/admin/guts-form.js', function(){
			loadForm(validatePatient);
		});
	});
});
</script>
<?php endif; ?>
```


