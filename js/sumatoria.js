$(document).ready(function(){
	
	/*
	* Esta funcion se usa para calcular subtotal, iva, y total
	*/
	calcular = function(nombreClase,subTotalId,multiplicando,iva,totalIva,totalId){
		var subtotal=0;
		var trim=0;
		var ivaTotal=0;

		$(nombreClase).each(function(){
			trim+=parseFloat(this.value);
		});
		//trim total
		$('#trim_total').val(trim);
		//subtotal
		subtotal=trim*$(multiplicando).val();
		$(subTotalId).val(subtotal);
		//iva
		ivaTotal=subtotal/100*$(iva).val();
		$(totalIva).val(ivaTotal);
		//total
		$(totalId).val(subtotal+ivaTotal);

	}

	trimTotal = function(nombreClase){
		var trim=0;

		$(nombreClase).each(function(){
			trim+=parseFloat(this.value);
		});
		//trim_total
		$('#trim_total').val(trim);
	}

	valorDefecto = function(nombreClase){

		$(nombreClase).each(function(){
			$(this).blur(function(){
				if($(this).val() === "")
				{
					$(this).val(0);
				}
			});
		});
	}	
	
});