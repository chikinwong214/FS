// JavaScript Document
//wosshzhb 

Highcharts.theme = {
	colors: ['#2DB929','#058DC7', '#FEC65C', '#008D58', '#78EDEA', '#A3E078', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
	chart: {
		
		backgroundColor: {
			linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
			stops: [
				[0, 'white'],
				[1, 'white']
			]
		}//,
		//borderWidth:1,
		//plotBackgroundColor: 'white',
		//plotShadow: false,//ͼ����Ӱ
		//plotBorderWidth:1,
		//borderRadius:3,
		//shadow:true//ͼ����Ӱ
		
	},
	title: {
		style: {
			color: 'black',
			font: 'bold 14px "����", Verdana, sans-serif'
		},
		align:'center'
	},
	subtitle: {
		style: {
			color: '#666666',
			font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
		},
		align:'left'
	},
	xAxis: {
		//gridLineWidth: 1,
		lineColor: '#000',
		tickColor: '#000',
		labels: {
			style: {
				color: '#000',
				font: '11px Trebuchet MS, Verdana, sans-serif'
			}
		},
		title: {
			style: {
				color: '#333',
				fontWeight: 'bold',
				fontSize: '12px',
				fontFamily: 'Trebuchet MS, Verdana, sans-serif'

			}
		}
	},
	yAxis: {
		//minorTickInterval: 'auto',
		min: 0,
		lineColor: '#000',
		lineWidth: 1,
		tickWidth: 1,
		tickColor: '#000',
		gridLineWidth:0,//���������
		labels: {
			style: {
				color: '#000',
				font: '11px Trebuchet MS, Verdana, sans-serif'
			}
		},
		title: {
			rotation:0,
			style: {
				color: '#333',
				fontWeight: 'bold',
				fontSize: '12px',
				fontFamily: 'Trebuchet MS, Verdana, sans-serif'
			}
		}
	},
	legend: {
		
		itemStyle: {
			font: '9pt Trebuchet MS, Verdana, sans-serif',
			color: 'black'

		},
		itemHoverStyle: {
			color: '#039'
		},
		itemHiddenStyle: {
			color: 'gray'
		}
	},
	labels: {
		style: {
			color: '#99b'
		}
	},

	navigation: {
		buttonOptions: {
			theme: {
				stroke: '#CCCCCC'
			}
		}
	}
};

// Apply the theme
var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
