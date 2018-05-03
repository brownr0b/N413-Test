<?php
include("php/n413connect.php");

$query = "SELECT id, country_code, country_name, travel_date, comments FROM countries";
$result = mysqli_query($link, $query);

$countries = Array();
$country_typeahead = Array();
while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)){		
	
	$countries[] = Array( 	"id" => $row["id"],
							"country_code" => $row["country_code"],
							"country_name" => $row["country_name"],
							"travel_date"  => $row["travel_date"],	
							"comments" => $row["comments"]);
							
	$country_typeahead[] = $row["country_name"];			
}

?>

<DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-datetimepicker.css" rel="stylesheet">
        <link href="css/n413_countries.css" rel="stylesheet">
		<script src="js/jquery-1.11.3.js"></script>
        <script src="js/moment.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap-datetimepicker.min.js" type="application/javascript"></script>
        <script src="js/typeahead.bundle.js"></script>
        <script src="js/fontawesome-all.js"></script>
        
        <title>N413 Countries</title>
        <script type="text/javascript">
		
			var country_typeahead = <?php echo json_encode($country_typeahead,JSON_HEX_APOS); ?>;
		
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip(); 
				
				//set up datepicker functions
				var options={ 	format: 'ddd, MMM D YYYY h:mm a',
								sideBySide: true
				 			 };
				
				$(".travel").datetimepicker(options); //add datepicker UI 
				
				$(".travel").datetimepicker().on('dp.change',function(event){
					var id = $(this).data('id');
					var traveldate = $(this).val();
					$.post("php/set_date.php",
							{id:id,traveldate:traveldate},
							function(data){
								if (data != "success"){alert(data);}
							},
							"text"
					);
				}); // $(".travel").datetimepicker().on('dp.change'
				
				//commentModal
				$('#commentModal').on('show.bs.modal', function (e) {
					//reset_error messages
					var this_form = "commentModal";
					$("#"+this_form+" #error_msg").removeClass("alert alert-danger");
					$("#"+this_form+" #error_msg").html("");
					$("#"+this_form+" #error_msg").css("display", "none");
					
					var comment_id = $(e.relatedTarget).data('id');
					$('#commentModal #comment_id').val(comment_id);
					var comment_text = $(e.relatedTarget).data('comment');
					$('#commentModal #comment').val(comment_text);
				});//end "on" function
				
				//comment/submit
				$("#comment_form").submit(function(e) {
					//prevent Default functionality
					e.preventDefault();
					var id = $('#commentModal #comment_id').val();
					var comment = $('#commentModal #comment').val();
					$.post("php/set_comment.php",
						{id:id, comment:comment},
						function(data){
							var this_form = "commentModal";
							if($.trim(data.status) == "success"){
								$("#comment_"+id).attr("title", comment).tooltip("fixTitle");
								$('#commentModal').modal('hide');
								var display_comment = comment.substring(0,10) + "...";
								var edit_comment = '<span data-toggle="modal" data-target="#commentModal" data-id="'+
								id+'" data-comment="'+
								comment+'"><i class="far fa-edit"></i> '+
								display_comment+'</span>';
								$("#comment_"+id).html(edit_comment);
							}else{
								$("#"+this_form+" #error_msg").addClass("alert alert-danger");
								$("#"+this_form+" #error_msg").html(data.status);
								$("#"+this_form+" #error_msg").css("display", "block");
							}
						},
						"json"
					);//$.post()
				});//submit()	

			/////////////////////typeahead scripts

			var substringMatcher = function(strs) {
				
			  return function findMatches(q, cb) {
				var matches, substringRegex;
			
				// an array that will be populated with substring matches
				matches = [];
			
				// regex used to determine if a string contains the substring `q`
				substrRegex = new RegExp(q, 'i');
			
				// iterate through the pool of strings and for any string that
				// contains the substring `q`, add it to the `matches` array
				$.each(strs, function(i, str) {
				  if (substrRegex.test(str)) {
					matches.push(str);
				  }
				});
			
				cb(matches);
			  };
			};
			
			$('#country_search .typeahead').typeahead({
			  hint: true,
			  highlight: true,
			  minLength: 1
			},
			{
			  name: 'country_typeahead',
			  source: substringMatcher(country_typeahead),
			  templates: {
				empty: [
				  '<div class="empty-message">',
					'No country names match the current query',
				  '</div>'
				].join('\n')}
			});

			}); //document.ready()

		</script>
    </head>
    
    <body>
    	<!-- BEGIN Bootstrap Navbar -->
    	<nav class="navbar navbar-inverse navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">N413 Countries</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
              <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </nav>
        <!-- END Bootstrap Navbar -->
        <div class="container" style="padding-top: 60px;">
          <div class="row">
            <div class="col-md-3"></div> <!-- 3-column spacer -->
            <div class="col-md-11"> <!-- column for content -->
            	<div id="country_search" class="btn-group pull-right">
            		<label class="label-font remove-padding">Country Search</label>
        			<input type="text" class="typeahead form-control" id="country_input" value="" placeholder="Country Name" />
      			</div> <!-- /.btn-group --> 
            	<h3>N413 Country List</h3>
                
            </div>  <!-- /.col-md-6 --> 
          </div>  <!-- /.row --> 
          <div class="row" style="margin-top:1em;margin-bottom:1em;">
              <div class="col-md-3"></div> <!-- 3-column spacer -->
            <div class="col-xs-1"> <!-- column for content -->
				<div>COUNTRY</div>
			</div>
            <div class="col-xs-3"> <!-- column for content -->
				<div>TRAVEL DATE</div>
			</div>
            <div class="col-xs-2" >
				<div>COMMENTS</div>
			</div>
		</div>  <!-- /.row -->
    <?php
    foreach ($countries as $country){
		$comments = "";
		if($country["comments"] > ""){$comments = substr($country["comments"],0,10)."...";}
		echo'
		<div class="row">
		    <div class="col-md-3"></div> <!-- 3-column spacer -->
            <div class="col-xs-1"> <!-- column for content -->
				<div data-toggle="tooltip" data-container="body" data-placement="left" title="'.$country["country_name"].'" id="'.$country["country_code"].'">'.$country["country_code"].'</div>
			</div>
			<div class="col-xs-3"> <!-- column for content -->
				<input type="text" class="travel" data-id="'.$country["id"].'" value="'.$country["travel_date"].'" placeholder="Travel Date" style="margin-bottom:0.5em;" />
			</div>
			<div class="col-xs-2" id="comment_'.$country["id"].'" data-toggle="tooltip" data-container="body" data-placement="left" title="'.$country["comments"].'"><i class="far fa-edit" data-toggle="modal" data-target="#commentModal" data-id="'.$country["id"].'" data-comment="'.$country["comments"].'" style="cursor:pointer;"></i> '.$comments.'</span>
			</div>
		</div>  <!-- /.row --> ';					
    }
    ?>
    		</div> <!-- /col-md-10 -->
    	  </div> <!-- /.row -->
    	</div>  <!-- /.container -->
        
        
        <!-- commentModal -->
        <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="commentModalLabel">Add/Edit Comment</h4>
              </div>
              <div class="modal-body">
                <div id="error_msg" style="display:none;"></div>
                <form id="comment_form" action="" method="" class="form">
                    <div class="form-group">
                        <label for="">Add/Edit Comment</label>
                        <textarea id="comment" style="width:100%;height:300px;">
                        </textarea>
                    </div>
                    <div style="overflow:hidden;">
                    	<input type="hidden" id="comment_id" value="" />
                        <input type="submit" class="btn btn-primary" value="Submit" style="float:right;"> 
                    </div>      	
                </form>
              </div> <!-- /modal body  -->
            </div>  <!-- /modal content  -->
          </div>  <!-- /modal dialog  -->
        </div>  <!-- /modal -->
    </body>
</html>