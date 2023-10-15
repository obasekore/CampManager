<script>
var maxi = 3;
var mini = 1;
var cnt =1;
var amount =<?= json_encode($temp2)?> ;
var status_amount=0;
//var temps = document.getElementById('publicDump').innerHTML;

$(document).ready(function(){

//Auto Check if male or female
<?php
if(isset($Delegate))
{
?>
	defaultGender= '<?= ($Delegate->getGender()) ?>';
	if(defaultGender=='Male')
	{
		$('input[value="Male"]').trigger('click');
	}
	else if(defaultGender=='Female')
	{
		$('input[value="Female"]').trigger('click');
	}

<?php
}
?>
//Navigation begins
	$('#forward').click(function(){
			cnt++;
			goto(cnt);
		});
	$('#jumpNav li').click(function(){
		goto(this.id);
	});
	
	$('#newReg').click(function(){
		$('#loader').show('slow');
		$.ajax({
			type: 'POST',
			url: 'route.php',
			data:{purp:'newDelegateRegistration'},
			success: function (msg) {
				$('#publicDump').html('');
				$('#publicDump').html(msg);
				$('#loader').hide('slow');
				$('#regModal').trigger('click');
			}
		});		
		/*alert('toor');
		$('#publicDump').html(temps);
		$('#regModal').trigger('click');*/

	});
	
	$('#delegate tr').click(function(){
		id=this.id;
		$('#loader').show('slow');
		$.ajax({
			type: 'POST',
			url: 'route.php',
			data:{ids:id,purp:'markAttendanceForCamp'},
			success: function (msg) {
				$('#publicDump').html('');
				$('#publicDump').html(msg);
				$('#loader').hide('slow');
				$('#regModal').trigger('click');
			}
		});		

		});
	
	function goto(pos)
	{
		//alert(pos);
		hideAll();
		if(pos==maxi){$('#genderDiv').trigger('click');}
		if(pos>maxi)
		{
				cnt=mini;pos=mini;
		}
		$('#zone'+pos).show('slow');
	}
	function hideAll()
	{
		for(i=mini; i<=maxi; i++)
			$('#zone'+i).hide();
	}
//Navigation Ends

//Handle Status and Money change
$('select[name="delegateStatus"]').change(function(){

	status = $('select[name="delegateStatus"]').val();
	status_amount = amount[status];
	$('#actualAmount').val(status_amount);
});

	$('#actualAmount').change(function(){
		if($('#actualAmount').val()!=status_amount)
		{
			text = '<input type="text" class="form-control" placeholder="Name of Person Responsible" name="personResponsible" id="personResponsible" required>';
			oldValue = ($('#actualAmount').val()!="")?$('#actualAmount').val():"";
			$('#amountDiv').html(text);
			$('#actualAmount').val(oldValue);
		}
		else
		{
			$('#amountDiv').html("");
			//$('select[name="delegateStatus"]').trigger('change');			
		}
		
	});
	
	
	});
	
</script>

<script>
<?php
$tempMale ="";
	foreach($house['male'] as $male)
	{
		$tempMale .= '<option value="'.$male.'">'.$male.'</option>';
	}
$tempFemale = "";
	foreach($house['female'] as $female)
	{
		$tempFemale .= '<option value="'.$female.'">'.$female.'</option>';
	}
?>
male = '<select name="house" class="form-control" required><option value="">...Please Select a gender...</option>'+'<?= $tempMale ?>'+'</select>';
female = '<select name="house" class="form-control" required><option value="">...Please Select a gender...</option>'+'<?= $tempFemale ?>'+'</select>';
$('#genderDiv').click(function(){
	genderValue = $('input[name="delegateGender"]:checked').val();//document.getElementsByName('delegateGender').value;
	if(genderValue=='Male')
    {
    	$('#houseDiv').html(male);
    }
	else if(genderValue=='Female')
	{
    	$('#houseDiv').html(female);
	}
	else
	{
		$('#houseDiv').html('<div class="alert-warning well"> Please select a gender</div>');
	}
});
</script>