
var Camera = {
    
    position = null, 
    direction = null,
    upVector = new Vector(0,0,1), 
    
    loadIdentity = function (vertex) {
        
        glu.lookAt();
    }, 
    
    lookAt : function () {
        
        
    }, 
    
    rotate : function (horizontal, vertical) {
        
        Math.hcos(this.direction.x);
        Math.hsin(this.direction.y);
        Math.hsin(this.direction.z);
    }, 
    
    straff : function (amount) {
        
        var direction = (new Vector(this.direction.x, this.direction.y, 0)).unit();
        var newX = this.position.x + direction.x * amount;
        var newY = this.position.y + direction.y * amount;
        this.position.add(newX, newY, 0);
    }, 
    
    move : function (amount) {
        
        var newX = this.position.x + this.direction.x * amount;
        var newY = this.position.y + this.direction.y * amount;
        var newZ = this.position.z + this.direction.z * amount;
        this.position.add(newX, newY, newZ);
    }
    
}
