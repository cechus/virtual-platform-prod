{!! Html::script('plugins/jQuery/jquery-2.2.3.min.js') !!}
{!! Html::script('plugins/slimScroll/jquery.slimscroll.min.js') !!}
{!! Html::script('plugins/input-mask/jquery.inputmask.bundle.js') !!}
{!! Html::script('bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
{!! Html::script('bower_components/bootstrap-material-design/dist/js/ripples.min.js') !!}
{!! Html::script('bower_components/bootstrap-material-design/dist/js/material.min.js') !!}
{!! Html::script('bower_components/data-tables/media/js/jquery.dataTables.min.js') !!}
{!! Html::script('bower_components/data-tables/media/js/dataTables.bootstrap.min.js') !!}
{!! Html::script('bower_components/knockout/dist/knockout.js') !!}
{!! Html::script('bower_components/bootstrap-combobox/js/bootstrap-combobox.js') !!}
{!! Html::script('bower_components/datePicker/js/bootstrap-datepicker.js') !!}
{!! Html::script('bower_components/chart.js/dist/Chart.min.js') !!}
{!! Html::script('vendor/selectize/dist/js/standalone/selectize.min.js') !!}
{!! Html::script('js/app.min.js') !!}
{!! Html::script('js/print.js') !!}


<script type="text/javascript">

	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

	$(document).on('ready', function(){
        $.material.init();
    });

    $(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip();
	});

	@if($errors->has())
    	$(document).ready(function(){
			$("#myModal-error").modal('show');
		});
	@endif

	@if (Session::has('message'))
    	$(document).ready(function(){
			$("#myModal-message").modal('show');
		});
	@endif
{{--
@if (Session::has('observation_type_id'))
			$(document).ready(function(){
				printTriggerObs('iFramePdfObservation');
			});
@endif
  --}}
	
	$(document).ready(function(){
		$("#search_type").change(function(){			
			if($(this).val() == 1)
				$("#searchbox").attr("placeholder", "Buscar afiliado...");
			else
				$("#searchbox").attr("placeholder", "Buscar derechohambiente...");
		});
		$('#searchbox').selectize({
	        valueField: 'url',
	        labelField: 'identity_card',
	        searchField: ['identity_card'],
	        maxOptions: 10,
	        options: [],
	        create: false,
	        render: {
	            option: function(item, escape) {
	                return '<div>' + escape(item.identity_card) + '<br>' + item.first_name + ' ' + item.last_name +'</div>';
	            }
	        },
	        optgroups: [
	            {value: 'affiliate', label: 'Titular:'},
	            {value: 'eco_com_applicant', label: 'Derechohabiente:'},
	            {value: 'spouse', label: 'Derechohabiente:'},
			],
	        optgroupField: 'class',
	        load: function(query, callback) {
	            if (!query.length) return callback();
	            $.ajax({
	                url: '{{url("search")}}',
	                type: 'GET',
	                dataType: 'json',
	                data: {
	                    q: query.toString().toUpperCase(),
						search_type: $("#search_type").val(),
	                },
	                error: function() {
	                    callback();
	                },
	                success: function(res) {
						console.log("wityh successfull result");
	                    callback(res.data);
	                }
	            });
	        },
	        onChange: function(){
	            window.location = this.items[0];
	        }
	    });
	});

	function printTriggerObs(elementId) {
				var getMyFrame = document.getElementById(elementId);
        getMyFrame.focus();
        getMyFrame.contentWindow.print();
    }

</script>
