
function VbmsPageViewingSystem () {
    
    
    
    
}

var SceneType = {
    /**
     * called when the scene is to be initialized
     */
    init : function () {
        
    },
    /**
     * called when the scene is to be destroyed
     */
    destroy : function () {
        
    },
    /**
     * called when the scene is to be updated
     */
    update : function (millis) {
        
    },
    /**
     * called when the scene is to be rendered
     */
    render : function () {
        
    }
}

var SceneTypeMoon = {
    
    backgroundTexture = null, 
    backgroundQuadratic = null, 
    backgroundDisplayList = null, 
    backgroundRadius = null, 
    
    earthTexture = null, 
    earthQudratic = null, 
    earthDisplayList = null, 
    
    moonTerrainDisplatList = null, 
    moonHeightMap = null, 
    
    radiusOfEarth = 6378100, 
    moonDistanceFromEarth = 63781000, 
    moonTerrainSize = 256, 
    moonTerrainStepSize = 1, 
    moonTerrainHeightMap = null, 
    moonTerrainHeightScale = 0.05, 
    
    /**
     * called when the scene is to be initialized
     */
    init : function () {
        
        gl.texGeni(gl.GL_S, gl.GL_TEXTURE_GEN_MODE, gl.GL_SPHERE_MAP);
        gl.texGeni(gl.GL_T, gl.GL_TEXTURE_GEN_MODE, gl.GL_SPHERE_MAP);
        
        gl.genTextures(1, backgroundTexture);
        
        // Create MipMapped Texture
        gl.bindTexture(gl.GL_TEXTURE_2D, texture[loop+4]);		// Gen Tex 4 and 5
        gl.texParameteri(gl.GL_TEXTURE_2D, gl.GL_TEXTURE_MAG_FILTER, gl.GL_LINEAR);
        gl.texParameteri(gl.GL_TEXTURE_2D, gl.GL_TEXTURE_MIN_FILTER, gl.GL_LINEAR_MIPMAP_NEAREST);
        //glu.build2DMipmaps(gl.GL_TEXTURE_2D, 3, TextureImage[loop]->sizeX, TextureImage[loop]->sizeY, gl.GL_RGB, gl.GL_UNSIGNED_BYTE, TextureImage[loop]->data);
        
        quadratic = glu.newQuadric();
        glu.quadricNormals(quadratic, glu.GLU_SMOOTH);
        glu.quadricTexture(quadratic, gl.GL_TRUE);
        
    },
    /**
     * called when the scene is to be destroyed
     */
    destroy : function () {
        
        glu.deleteQuadric(this.quadratic);
    },
    /**
     * called when the scene is to be updated
     */
    update : function (millis) {
        
    },
    /**
     * called when the scene is to be rendered
     */
    render : function () {
        
        gl.loadIdentity();
        
        // init lights
        //gl.enable();
        
        gl.enable(gl.GL_TEXTURE_GEN_S);
        gl.enable(gl.GL_TEXTURE_GEN_T);
        
        // draw background
        gl.bindTexture(gl.GL_TEXTURE_2D, this.backgroundTexture);
        glu.sphere(this.backgroundQudratic, this.backgroundRadius, 32, 32);
        
        // draw earth
        gl.bindTexture(gl.GL_TEXTURE_2D, this.earthTexture);
        
        gl.pushMatrix();
        gl.translate(0,0,this.moonDistanceFromEarth);
        
        gl.bindTexture(gl.GL_TEXTURE_2D, this.earthTexture);
        glu.sphere(this.earthQuadratic, 32, 32);
        gl.popMatrix();
        
        // draw atmasphere
        
        // draw sun
        
        /*
        gl.pushMatrix();
        gl.translate(this.sunPosition.x, this.sunPosition.y, this.sunPosition.z);
        gl.rotate();
        */
        
        // draw moon surface
        
        gl.pushMatrix();
        gl.translate(-((this.moonTerrainStepSize * this.moonTerrainSize) / 2.0), -((this.moonTerrainStepSize * this.moonTerrainSize) / 2.0), 0);
        gl.enable(gl.GL_TEXTURE_2D);
        gl.bindTexture(gl.GL_TEXTURE_2D, this.moonTexture);
        for (var y=0; y<this.moonTerrainSize-1; y++) {
            gl.begin(gl.QUAD_STRIP);
            for (var x=0; x<this.moonTerrainSize; x++) {
                gl.normal();
                gl.texturecord(x % 2 == 0 ? 0 : 1, x % 2 == 0 ? 1 : 0);
                gl.vertex(x * this.moonTerrainStepSize, y * this.moonTerrainStepSize, this.moonTerrainHeightMap[y][x] * this.moonTerrainHeightScale);
                gl.texturecord(x % 2 == 0 ? 1 : 0, x % 2 == 0 ? 0 : 1);
                gl.vertex(x * this.moonTerrainStepSize, (1 + y) * this.moonTerrainStepSize, this.moonTerrainHeightMap[y+1][x] * this.moonTerrainHeightScale);
            }
            gl.end();
        }
        gl.popMatrix();
        
        // 
    }
}



