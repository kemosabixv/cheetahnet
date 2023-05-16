
<script>

(function (nx) {
	nx.define('MyTopology', nx.graphic.Topology, {
		methods: {
			"init": function(){
				this.inherited({
					// width 100% if true
					'adaptive': true,
					// show icons' nodes, otherwise display dots
					'showIcon': true,
					// special configuration for nodes
					'nodeConfig': {
						'label': 'model.name',
						'iconType': 'router',
						'color': 'model.color'
					},
					// special configuration for links
					'linkConfig': {
						'linkType': 'curve',
            'color': 'model.color'
					},
					// property name to identify unique nodes
					'identityKey': 'id', // helps to link source and target
					// canvas size
					'width': 1000,
					'height': 600,
					// "engine" that process topology prior to rendering
					'dataProcessor': 'force',
					// moves the labels in order to avoid overlay
					'enableSmartLabel': true,
					// smooth scaling. may slow down, if true
					'enableGradualScaling': true,
					// if true, two nodes can have more than one link
					'supportMultipleLink': true,
					// enable scaling
					"scalable": true
				});
			}
		}
	});
})(nx);


(function(nx){

// instantiate NeXt app
var app = new nx.ui.Application();

// instantiate Topology class
var topology = new MyTopology();

getDevicesTopology("tdata", function(tdata) {
    // load topology data from app/data.js
    topology.data(tdata);
   });

// bind the topology object to the app
topology.attach(app);

// app must run inside a specific container. In our case this is the one with id="topology-container"
app.container(document.getElementById("topology-container"));

})(nx);


function getDevicesTopology(tdata, callback){
$.ajax({
  type: 'POST',
  url: "getTopology",
  data: {tdata:tdata},
  cache: false,
  contentType: false,
  processData: false,
  success: (data) => {
    //console.log(data);
    callback(data);
  },
  error: function(data) {
      console.log(data);
  }
});
}


</script>