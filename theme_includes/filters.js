'use strict';
app.filter('postDate',function(){

  return function(dd){
    var dt = dd.split(" ");
    return dt[0];
  };

});

app.filter('postTags',function(){
  return function(tagString){

    var tags = tagString.split(",");
    var ret = '';
    for(var i=0;i<tags.length;++i){
      tags[i] = '<label class="tags">#'+tags[i];
      ret += tags[i];
      if(i < tags.length-1) ret += '</label> ';
    }
    return ret;
  };
});
