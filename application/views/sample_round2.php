<?php

	echo $data;
?>

<?php echo base_url(); ?>
<html>
	<head>
			<script src="/js/jquery.min.js"></script>
			<script type="text/javascript">
				$(document).ready(function(){
				
				/*$.ajax({
					url: "/round2/getQuestionBody/<?php echo $data?>",
					type: 'POST',
					success: function (data) {
						document.write(data);
					}
					
					});
				});
			
				*/

			</script>
	</head>
	<body>
			<div id="question">Question</div>
	</body>
</html>