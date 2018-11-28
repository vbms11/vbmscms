

var Class : function () {
	
	instance : function (class) {
		
	},
	
	implement : function (parentClass, subClass) {
		var instance = new parentClass();
		for (var item in subClass) {
			instance[item] = subClass[item];
		}
		return instance;
	},
	
	abstract : function (class) {
		
	}
}

var Process : Class.abstract({
	
	state_run : null,
	reportUrl : null,
	
	uploadComplete : null,
	uploadError : null,
	
	processInterval : 893,
	taskInterval : 500
	processIntervalId : 893,
	taskIntervalId : 500
	
	process : function (tasks) {
	},
	isReady : function () {
		
	},
	init : function (data) {
		
	},
	
	start : function (tasks) {
		
		this.taskIntervalId = setInterval(this.taskInterval, function(){
			
		});
		this.processIntervalId = setInterval(this.processInterval, function(){
			if (this.isRun()) {
				process();
			}
		});
		this.state_run = true;
		this.process(tasks);
	},
	stop : function () {
		this.state_run = false;
	},
	isRun : function () {
		return this.state_run;
	},
	upload : function (data) {
		var that = this;
		var str_data = JSON.stringify(data);
		var result = $.json(this.reportUrl, {"data": data}, function(json){
			switch(json.status) {
				case Process.status_done:
					if (typeof that.uploadComplete  == "function") {
						that.uploadComplete();
					}
					break;
				case Process.status_error:
					if (typeof that.uploadError == "function") {
						that.uploadError();
					}
					break;
			}
		});
	}
});

var KeywordProcess : Class.abstract(Process, {
	
	keywordPagesState : null,
	keywordPagesState_ready : 1,
	keywordPagesState_error : 2,
	keywordPagesState_waiting : 3,
	keywordPagesState_finnished : 4,
	
	getData : null,
	hasNext : null,
	
	process : function (tasks) {
		
		switch (this.keywordPagesState) {
			case keywordPagesState:
				break;
			case keywordPagesState_ready:
				if (typeof this.hasNext == "function" && this.hasNext()) {
					this.next();
				} else {
					this.keywordPagesState = this.keywordPagesState_finnished;
				}
				break;
			case keywordPagesState_error:
				break;
			case keywordPagesState_waiting:
				break;
			case keywordPagesState_finnished:
				break;
		}
	},
	
	reportNext : function () {
		if (typeof this.getData == "function") {
			this.upload(this.getData());
		}
		this.keywordPagesState = this.keywordPagesState_ready;
	},
	
	next : function () {
		return false;
	}
	
};

var SelectorKeywordProcess = Class.implement(KeywordProcess, {
	
	currentPage : null,
	position : null,
	url : null,
	tasks : null,
	urlSelector : null,
	nextSelector : null,
	
	init : function (url, tasks, urlSelector, nextSelector) {
		this.position = 0;
		this.url = url;
		this.tasks = tasks;
		this.urlSelector = urlSelector;
		this.nextSelector = nextSelector;
	},
	
	getData : function () {
		var urls = $(this.currentPage).find(this.urlSelector);
		return urls;
	},
	
	hasNext : function () {
		return $(this.currentPage).find(this.nextSelector);
	},
	
	next : function () {
		var nextUrl = $(this.currentPage).find(this.nextSelector);
		if (!nextUrl) {
			return false;
		}
		$.get(nextUrl, function(data){
			this.currentPage = data;
			this.reportNext();
		});
		return true;
	}
	
});

/*



*/

var ProcessManager = {
	
	processListUrl : "/?s=processList&action=processJson";
	processes : [],
	processInterval : 1000,
	processIntervalId : null,
	processList : null,
	
	status : null,
	status_init : 1,
	status_processList : 2,
	status_loadProcess : 3,
	status_maintain : 4,
	status_stop : 5,
	
	clear : function () {
		this.processes = [];
	},
	
	add : function (process) {
		this.processes[this.process.name] = process;
	},
	
	remove : function (name) {
		delete this.processes[name];
	},
	
	refreshLoadProcesses : function () {
		
		// load processes if not in the list
		for (var process in data.processes) {
			if (this.processes[process.name] == undefined) {
				this.loadProcess(process.url);
			}
		}
	},
	
	refreshProcessList : function () {
		
		$.json(this.processListUrl, function (data) {
			this.processList = data;
		});
	},
	
	start : function () {
		
		var that = this;
		
		processIntervalId = setInterval(this.processInterval, function () {
			
			refreshProcessList
		});
		
		
		$.json(this.processListUrl, function (data) {
			
			// get list of processes
			$.inArray(iBarCode, myArray) == -1 
			$.each(data, function (index, process), {
				
				// stop old processes
				
				this.processes = ;
				// run if process stopped
				switch (process.status) {
					case Process.status_stopped:
						process.start();
					case Process.status_running:
						break;
				}
					
			});
		});
	},
	
	loadProcess : function (process) {
		$.getScript(process.url, function(data, textStatus, jqxhr) {
			Device.log("Process Loaded: "+process.name);
		});
	}
	
}
