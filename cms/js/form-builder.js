jQuery(function($){

  	var fields = [];
  	var inputSets = [];

  	var templates = {};

   	var defaultFields =  [{
	      	className: "form-control",
	      	label: 'First Name',
	      	name: 'first-name',
	      	required: true,
	      	description: 'Your first name',
	      	type: 'text',
	    }, {
	      	className: "form-control",
	      	label: 'Last Name',
	      	name: 'last-name',
	      	required: true,
	      	description: 'Your last name',
	      	type: 'text'
	    }, {
	      	className: "form-control",
	      	label: 'Email Address',
	      	name: 'email-address',
	      	required: true,
	      	description: 'Your email address',
	      	type: 'text'
	  	}];

  
  	var typeUserDisabledAttrs = {
        'textarea': ['subtype']
      };

    var typeUserAttrs = {
    	text: {
    		subtype: {
	            label: 'Type',
	            options: {
		              	'text': 'Text Field',
		              	'email': 'Email',
		              	'tel': 'Telephone'
		            }
	          	}
        	},

        header: {
        	subtype: {
	            label: 'Type',
	            options: {
		              	'h2': 'Heading 2',
		              	'h3': 'Heading 3',
		              	'h4': 'Heading 4'
		            }
	          	}
        	},
    	};

	var fbOptions = {
      	defaultFields         : defaultFields,     
      	stickyControls        : {enable: true},
      	sortableControls      : true,
      	fieldRemoveWarn		  : true,
      	fields                : fields,
      	templates             : templates,
      	inputSets             : inputSets,
      	disableInjectedStyle  : false,
      	disabledActionButtons : ['data', 'clear','save'],
      	disabledAttrs         : ['access','rows','maxlength','inline','other','multiple'],
      	disableFields         : ['autocomplete', 'file', 'button', 'number', 'hidden','paragraph'],
      	controlOrder          : ['text', 'textarea', 'select', 'radio-group', 'checkbox-group', 'date',  'header'],
      	controlPosition       : 'left',
      	typeUserDisabledAttrs : typeUserDisabledAttrs,
      	typeUserAttrs 		  : typeUserAttrs,
	};

	var formData = $('#formData').val();

	if (formData !='') {
	    fbOptions.formData = formData;
	}

  	var fbEditor = document.getElementById('build-wrap');
  	var formBuilder = $(fbEditor).formBuilder(fbOptions);
	
	$('#save-changes').on('click', function(e){

	    e.preventDefault();
	    //e.stopPropagation();

	    var self = $(this),
	        formId   = jsVars.data.formId,
	        xmlTemplate = formBuilder.actions.getData('xml'),
	        jsonTemplate = formBuilder.actions.getData('json');

	    if( formId ) {

	      	var serviceUrl = jsVars.baseUrl+'ajax/service.php';

	      	$.post(serviceUrl, 'action=save-form&id='+formId+'&xml='+xmlTemplate+'&json='+jsonTemplate, function( response ) {
	        	
	        	submitForm('save', 1);

	      	}, 'json'); 

	    } 

  });

});