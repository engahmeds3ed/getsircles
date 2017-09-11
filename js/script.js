$(document).ready(function(){

	function reBuildString(){
		var thisString = $('#string');
		var taskMatches = thisString.html().match(/"([^"]+)"/g);//this regex to get text between double quotes ""
		var stepMatches = thisString.html().match(/\[([^\]]*)\]/g);//this regex to get text between squares []

		//loop on all tasks to rebuild the string based on tasks and steps from the table
		$('.task').each(function(){
			var dom_task = $(this);

			var taskSteps = [];
			//loop on all steps but save only steps related to this task into "taskSteps" array 
			$('.step').each(function(){
				var dom_step = $(this);
				if(dom_step.data('taskkey') == dom_task.data('taskkey')){
					taskSteps.push( dom_step.html() );
				}
			});

			//update task and steps
			thisString.html(thisString.html()
				.replace(taskMatches[dom_task.data('taskkey')],'"'+dom_task.html()+'"')
				.replace(stepMatches[dom_task.data('taskkey')],'['+taskSteps.join(' -> ')+']')
			);

		});
	}

	$('.task,.step').dblclick(function(){
		var thisItem = $(this);
		var oldValue = thisItem.html();
		//create an input instead of the text to help you edit
		var inputElement = $('<input />',{
			"class": "inputText",
			"value": "",
			"keypress": function(e){
				//if Enter button is clicked so convert this input to HTML then call reBuildString function
				if(e.which == 13) {
			        thisItem.html($(this).val());
			        reBuildString();
			    }
			},
			"blur": function(){//if any other element on page clicked convert this input to HTML then call reBuildString function
				thisItem.html($(this).val());
			    reBuildString();
			}
		});
		thisItem.html("<div><small>Press Enter to save</small></div>");//for a hint
		inputElement.appendTo(thisItem);
		inputElement.focus();//focus on this input
		inputElement.val(oldValue);//to add focus cursor at end of input element
	});

});