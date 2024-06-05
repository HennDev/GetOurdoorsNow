<?php
	session_start();	
    $title = "Edit an Outfitter";
	include($_SERVER['DOCUMENT_ROOT']."/database.php");	
	include($_SERVER['DOCUMENT_ROOT']."/common.php");
	include($_SERVER['DOCUMENT_ROOT'].'/include/top_start.php');
	// Any extra scripts go here
        
?>
<link href="/css/simple-sidebar.css" rel="stylesheet">
<style>
	html { margin:0; padding:0; font-size:62.5%; }
	body { max-width:800px; min-width:300px; margin:0 auto; padding:20px 10px; font-size:14px; font-size:1.4em; }
	h1 { font-size:1.8em; }
	.demo { overflow:auto; border:1px solid silver; min-height:100px; }
	</style>
	<link rel="stylesheet" href="/css/themes/default/style.min.css" />
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/include/top_end.php');
?>
<h1>HTML demo</h1>
	<div id="html" class="demo">
		<ul>
			<li data-jstree='{ "opened" : true }'>Root node
				<ul>
					<li data-jstree='{ "selected" : true }'>Child node 1</li>
					<li>Child node 2</li>
				</ul>
			</li>
		</ul>
	</div>

	<h1>Inline data demo</h1>
	<div id="data" class="demo"></div>
	<form id="s">
  <input type="search" id="q" />
  <button type="submit">Search</button>
</form>

	<h1>Data format demo</h1>
	<div id="frmt" class="demo"></div>

	<h1>AJAX demo</h1>
	<div id="ajax" class="demo"></div>

	<h1>Lazy loading demo</h1>
	<div id="lazy" class="demo"></div>

	<h1>Callback function data demo</h1>
	<div id="clbk" class="demo"></div>

	<h1>Interaction and events demo</h1>
	<button id="evts_button">select node with id 1</button> <em>either click the button or a node in the tree</em>
	<div id="evts" class="demo"></div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="/js/jstree.min.js"></script>
	
	<script>
	// html demo
	$('#html').jstree();

	// inline data demo
	$('#data').jstree({'plugins':["wholerow","checkbox","search"], 'core' : {
			'data' : [
				{ "text" : "Root node", "children" : [
						{ "text" : "Child node 1" },
						{ "text" : "Child node 2" }
				]}
			]
		}
	});
	
	
$("#q").keyup(function(e) {
  e.preventDefault();
  $("#data").jstree(true).search($("#q").val());
});


	// data format demo
	$('#frmt').jstree({'plugins':["wholerow","checkbox"], 'core' : {
			'data' : [
				{
					"text" : "Root node",
					"state" : { "opened" : true },
					"children" : [
						{
							"text" : "Child node 1",
							"icon" : "jstree-file"
						},
						{ "text" : "Child node 2" }
					]
				}
			]
		}
	});

	// ajax demo
	$('#ajax').jstree({'plugins':["wholerow","checkbox"], 'core' : {
			'data' : {
				"url" : "./root.json",
				"dataType" : "json" // needed only if you do not supply JSON headers
			}
		}
	});

	// lazy demo
	$('#lazy').jstree({'plugins':["wholerow","checkbox"], 'core' : {
			'data' : {
				"url" : "//www.jstree.com/fiddle/?lazy",
				"data" : function (node) {
					return { "id" : node.id };
				}
			}
		}
	});

	// data from callback
	$('#clbk').jstree({'plugins':["wholerow","checkbox"], 'core' : {
			'data' : function (node, cb) {
				if(node.id === "#") {
					cb([{"text" : "Root", "id" : "1", "children" : true}]);
				}
				else {
					cb(["Child"]);
				}
			}
		}
	});

	// interaction and events
	$('#evts_button').on("click", function () {
		var instance = $('#evts').jstree(true);
		instance.deselect_all();
		instance.select_node('1');
	});
	$('#evts')
		.on("changed.jstree", function (e, data) {
			if(data.selected.length) {
				alert('The selected node is: ' + data.instance.get_node(data.selected[0]).text);
			}
		})
		.jstree({
			'core' : {
				'multiple' : false,
				'data' : [
					{ "text" : "Root node", "children" : [
							{ "text" : "Child node 1", "id" : 1 },
							{ "text" : "Child node 2" }
					]}
				]
			}
		});
	</script>

<script src="/js/holder.js"></script>
<?php include($_SERVER['DOCUMENT_ROOT'].'/include/bottom.php');?>
 

