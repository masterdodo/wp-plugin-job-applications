function AddVehicle()
{
	var ExistingSelect = document.querySelector('select[name=vehicle1a]');
	console.log(ExistingSelect);
	var cloneSelect = ExistingSelect.cloneNode(true);
	var SelectLength = document.querySelectorAll('.vehicles select').length;
	SelectLength += 2;
	var Lock = SelectLength - 1;
    var LockSelect = document.querySelector('select[name=vehicle' + Lock + 'a]');
    if(LockSelect.value != "")
    {
	    LockSelect.disabled = true;
	    var vehicleNumber = 'vehicle' + SelectLength + 'a';
	    cloneSelect.setAttribute('name',vehicleNumber);
	    cloneSelect.disabled = false;
	    var newDiv = document.createElement('div');
	    newDiv.setAttribute('class','vehicles');
	    newDiv.appendChild(cloneSelect);
	    var divBefore = document.querySelector('#driving_categories');
	    parentNode = divBefore.parentNode;
        parentNode.insertBefore(newDiv, divBefore);
    }
}