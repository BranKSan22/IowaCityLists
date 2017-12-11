//Controls data for informaticsfinal
(function () {
    'use strict';
    
    var myApp = angular.module("iowaList");
    myApp.controller("dataControl", function($scope, $http, $window) {
		
    //SelectedArea pertaining to users account
    $scope.account_id = "";
    var selectedArea = null;
    
    $scope.selectArea = function(newArea) {
        selectedArea = newArea;
    };
    
    //Allows user to create a new account (Sign Up)
    $scope.newAccount = function(accountDetails) {
            var account = angular.copy(accountDetails);
            
            $http.post("newaccount.php", account)
                .then(function (response) {
                if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert ('error: ' + response.data.message);
                    } else {
                        $window.location.href ="index.html";
                    }
                } else {
                    alert('unexpected error');
                }
            });
        };
        
        //Prompts user to login into account 
        $scope.login = function(credentialDetails) {
            var credentials = angular.copy(credentialDetails);
            
            $http.post("login.php", credentials)
                .then(function (response) {
                if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert ('error: ' + response.data.message);
                    } else {
                        $window.location.href ="index.html";
                    }
                } else {
                    alert('unexpected error');
                }
            });
        };        
        

        //Prompts user to login into account 
        $scope.logout = function() {
            $http.post("logout.php")
                .then(function (response) {
                if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert ('error: ' + response);
                    } else {
                        $window.location.href ="index.html";
                    }
                } else {
                    alert('unexpected error');
                }
            });
        };
        
        //Controls data dependent on if the user is logged in
        $scope.isloggedin = function() {
           $http.post("isloggedin.php")
                .then(function (response) {
                if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert ('error: ' + response.data.message);
                    } else {
                        $scope.isloggedin = response.data.loggedin;
                        $scope.account_id = response.data.account_id;
                    }
                } else {
                    alert('unexpected error');
                }
            });            
        };
    
            //Get session variable
        $scope.getSessionVariable = function(attribute) {
           $http.post("getsessionvariable.php", attribute)
                .then(function (response) {
                if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert ('error: ' + response.data.message);
                    } else {
                        //successful
                        // return value of attribute
                        return response.data.value;
                    }
                } else {
                    alert('unexpected error');
                }
            });            
        };
        
        //Set session variable
        $scope.setSessionVariable = function(attribute, value) {
           $http.post("setsessionvariable.php", {"attribute": attribute, "value":value})
                .then(function (response) {
                if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert ('error: ' + response.data.message);
                    } else {
                        //successful
                        return true;
                    }
                } else {
                    alert('unexpected error');
                }
            });            
        };
    
    
    //Displays only users list that is logged in 
    $scope.areaEdit = function(list) {
            if (list.id == $scope.currentlistid) {
                return true;
            } else {
                return false;
            }
    };
    
    //Filters list based on the user
    $scope.areaFilter = function(list) {
        if (selectedArea === null) {
            return true;
        } else {
            if (list.account_id == $scope.account_id) {
                return true;
            } else {
                return false;
            }
        }
    };
    
    $scope.getAreaClass = function (area) {
      if ((selectedArea == area) || (area == 'all' && selectedArea === null)) {
        return "btn-primary";
      } else {
        return "";
      }
    };
       
        //Template.php
        $http.get("getTemplate.php")
            .then(function(response) {
                $scope.templates = response.data;
            });
            
             //Userlist.php
        $http.get("getUserLists.php")
            .then(function(response) {
                $scope.userlists = response.data;
            });
        
        
         //Saves new items to the list  
        $scope.newitem = function(saveitem) {
            var items = angular.copy(saveitem);
            
             $http.post("saveitem.php", items)
                .then(function (response) {
                if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert ('error: ' + response.data.message);
                    } else {
                        $window.location.href ="editlist.html"; 
                    }
                } else {
                    alert('unexpected error');
                }
            });
        };
        

        //Saves list and puts it on webpage (editlist.html)
        $scope.publishList = function(publishit) {
            var publishitems = angular.copy(publishit);
            
             $http.post("editlist.php", publishitems )
                .then(function (response) {
                if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert ('error: ' + response.data.message);
                    } else {
                        $window.location.href ="editlist.html";
                    }
                } else {
                    alert('unexpected error');
                }
            });
        };
        
        //Allows the user to save their list and add more to the list
        $scope.editList = function(listItem) {
            var itemsInL = angular.copy(listItem);
            
             $http.post("editlist.php", itemsInL)
                .then(function (response) {
                if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert ('error: ' + response.data.message);
                    } else {
                        $window.location.href ="editlist.html"; 
                    }
                } else {
                    alert('unexpected error');
                }
            });
        };
        
        //Saves the newly created lists' name
        $scope.newList = function(listname) {
            var name = angular.copy(listname);
            
             $http.post("createlist.php", name)
                .then(function (response) {
                if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert ('error: ' + response.data.message);
                    } else {
                    
                        $window.location.href ="editlist.html";
                    }
                } else {
                    alert('unexpected error');
                }
            });
        };
        
        
      
        //Grabs attribute fromt template 
        $scope.getAttr = function() {
            $http.get("getAttr.php")
                .then(function(response) {
                    console.log(response);
                    $scope.attrs = response.data.value;
                });
                
        };

        //Lists.php
        $http.get("getlists.php")
            .then(function(response) {
                $scope.data = response.data.value;
            });        
      
        $scope.datatype = function(item) {
        return item.type;
      };
      
         //Updates a given list "php"
        $scope.editList = function(listDetails, id) {
            var list = angular.copy(listDetails);
            
            list.id = id;
            $http.post("updatelist.php", list)
                .then(function (response) {
                if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert ('error: ' + response.data.message);
                    } else {
                        
                        $window.location.href ="userlist.html";
                    }
                } else {
                    alert('unexpected error');
                }
            });
        };
        
         //Edit mode to edit attribute 
        $scope.setEditMode = function(on, attribute) {
            if (on) {
                $scope.editattribute = angular.copy(attribute);
                attribute.editMode = true;
            } else {
                attribute.editMode = false;
            }
        };
        
         //Returns the editMode for the current item (or list)
        $scope.getEditMode = function(attribute) {
            return attribute.editMode;
        };

        //Update attribute within a list (php)
        $scope.updateAttribute = function(editattribute) {
            var edit = angular.copy(editattribute);
            $http.post("updateattribute.php", edit)
                .then(function (response) {
                if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert ('error: ' + response.data.message);
                    } else {
                        $window.location.href ="userlist.html";
                    }
                } else {
                    alert('unexpected error');
                }
            });
        };
        
        //Delete a list 
        $scope.deleteList = function(name, id) {
            if (confirm("Are you sure you want to delete " + name + "?")) {
                $http.post("deletelist.php", {"id" : id})
                    .then(function (response) {
                    if (response.status == 200) {
                        if (response.data.status == 'error') {
                            alert ('error: ' + response.data.message);
                        } else {
                            $window.location.href ="userlist.html";
                        }
                    } else {
                        alert('unexpected error');
                    }
                });
            }
        };
        
        //Delete a attribute within a list 
        $scope.deleteAttribute = function(attribute) {
            if (confirm("Are you sure you want to delete " + attribute.label + " " + attribute.value + "?")) {
                $http.post("deleteattribute.php", {"id" : attribute.id, "value":attribute.value})
                    .then(function (response) {
                    if (response.status == 200) {
                        if (response.data.status == 'error') {
                            alert ('error: ' + response.data.message);
                        } else {
                            $window.location.href ="userlist.html";
                        }
                    } else {
                        alert('unexpected error');
                    }
                });
            }
        };
               //Add list (php)
               $scope.addList = function(id) {
                $http.post("addlist.php", {"id" : id})
                    .then(function (response) {
                    if (response.status == 200) {
                        if (response.data.status == 'error') {
                            alert ('error: ' + response.data.message);
                        } else {
                            $window.location.href ="editlist.html";
                        }
                    } else {
                        alert('unexpected error');
                    }
                });
            
        };        //Allows users to thumb up a list 
                  $scope.thumbsup = function(list) {
                    var id = angular.copy(list);
                    $http.post("thumbsup.php", {"id":id})
                        .then(function (response) {
                    if (response.status == 200) {
                        if (response.data.status == 'error') {
                            alert ('error: ' + response.data.message);
                        } else {
                            //successful
                            $window.location.href ="alllist.html"; // doesn't need to reload page
                        }
                    } else {
                        alert('unexpected error');
                     }
                });
       };
                     //Allows users to thumb down a list 
                    $scope.thumbsdown = function(list) {
                        var id = angular.copy(list);
                     $http.post("thumbsdown.php", {"id":id})
                         .then(function (response) {
                    if (response.status == 200) {
                        if (response.data.status == 'error') {
                            alert ('error: ' + response.data.message);
                        } else {
                            $window.location.href ="alllist.html"; 
                        }
                    } else {
                        alert('unexpected error');
                     }
                });
       };                  
    });
    
} )();
