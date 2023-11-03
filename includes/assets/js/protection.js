if (jh_disabled_options_data.disabled_click == "1") {
   document.addEventListener('contextmenu', function(e) {
      if(jh_disabled_options_data.disabled_notifi_status=="1" && jh_disabled_options_data.disabled_notifi_text!=""){
         jQuery.notify(jh_disabled_options_data.disabled_notifi_text,
            {position:"right",
            className: 'error',  
            showAnimation: 'fadeIn', 
            hideAnimation: 'fadeOut', 
            style: 'bootstrap'
            }
         );
      }
      e.preventDefault();
   });
}

document.onkeydown = function(e) {
   if (jh_disabled_options_data.disabled_f12 == "1") {
      if (event.keyCode == 123) {
         if(jh_disabled_options_data.disabled_notifi_status=="1" && jh_disabled_options_data.disabled_notifi_text!=""){
            jQuery.notify(jh_disabled_options_data.disabled_notifi_text,
               {position:"right",
               className: 'error',  
               showAnimation: 'fadeIn', 
               hideAnimation: 'fadeOut', 
               style: 'bootstrap'
               }
            );
         }
         return false;
      }
   }
   if (jh_disabled_options_data.disabled_ctst_i == "1") {
      if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
         if(jh_disabled_options_data.disabled_notifi_status=="1" && jh_disabled_options_data.disabled_notifi_text!=""){
            jQuery.notify(jh_disabled_options_data.disabled_notifi_text,
               {position:"right",
               className: 'error',  
               showAnimation: 'fadeIn', 
               hideAnimation: 'fadeOut', 
               style: 'bootstrap'
               }
            );
         }
         return false;
      }
      if (e.ctrlKey && e.keyCode == 'I'.charCodeAt(0)) {
         if(jh_disabled_options_data.disabled_notifi_status=="1" && jh_disabled_options_data.disabled_notifi_text!=""){
            jQuery.notify(jh_disabled_options_data.disabled_notifi_text,
               {position:"right",
               className: 'error',  
               showAnimation: 'fadeIn', 
               hideAnimation: 'fadeOut', 
               style: 'bootstrap'
               }
            );
         }
         return false;
      }
   }
   if (jh_disabled_options_data.disabled_ctst_c == "1") {
      if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
         if(jh_disabled_options_data.disabled_notifi_status=="1" && jh_disabled_options_data.disabled_notifi_text!=""){
            jQuery.notify(jh_disabled_options_data.disabled_notifi_text,
               {position:"right",
               className: 'error',  
               showAnimation: 'fadeIn', 
               hideAnimation: 'fadeOut', 
               style: 'bootstrap'
               }
            );
         }
         return false;
      }
      if (e.ctrlKey && e.keyCode == 'C'.charCodeAt(0)) {
         if(jh_disabled_options_data.disabled_notifi_status=="1" && jh_disabled_options_data.disabled_notifi_text!=""){
            jQuery.notify(jh_disabled_options_data.disabled_notifi_text,
               {position:"right",
               className: 'error',  
               showAnimation: 'fadeIn', 
               hideAnimation: 'fadeOut', 
               style: 'bootstrap'
               }
            );
         }
         return false;
      }
   }
   if (jh_disabled_options_data.disabled_ctst_j == "1") {
      if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
         if(jh_disabled_options_data.disabled_notifi_status=="1" && jh_disabled_options_data.disabled_notifi_text!=""){
            jQuery.notify(jh_disabled_options_data.disabled_notifi_text,
               {position:"right",
               className: 'error',  
               showAnimation: 'fadeIn', 
               hideAnimation: 'fadeOut', 
               style: 'bootstrap'
               }
            );
         }
         return false;
      }
      if (e.ctrlKey && e.keyCode == 'J'.charCodeAt(0)) {
         if(jh_disabled_options_data.disabled_notifi_status=="1" && jh_disabled_options_data.disabled_notifi_text!=""){
            jQuery.notify(jh_disabled_options_data.disabled_notifi_text,
               {position:"right",
               className: 'error',  
               showAnimation: 'fadeIn', 
               hideAnimation: 'fadeOut', 
               style: 'bootstrap'
               }
            );
         }
         return false;
      }
   }
   if (jh_disabled_options_data.disabled_ct_u == "1") {
      if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
         if(jh_disabled_options_data.disabled_notifi_status=="1" && jh_disabled_options_data.disabled_notifi_text!=""){
            jQuery.notify(jh_disabled_options_data.disabled_notifi_text,
               {position:"right",
               className: 'error',  
               showAnimation: 'fadeIn', 
               hideAnimation: 'fadeOut', 
               style: 'bootstrap'
               }
            );
         }
         return false;
      }
   }
   if (jh_disabled_options_data.disabled_ct_s == "1") {
      if (e.ctrlKey && e.keyCode == 'S'.charCodeAt(0)) {
         if(jh_disabled_options_data.disabled_notifi_status=="1" && jh_disabled_options_data.disabled_notifi_text!=""){
            jQuery.notify(jh_disabled_options_data.disabled_notifi_text,
               {position:"right",
               className: 'error',  
               showAnimation: 'fadeIn', 
               hideAnimation: 'fadeOut', 
               style: 'bootstrap'
               }
            );
         }
         return false;
      }
   }
}

if (jh_disabled_options_data.disabled_dragging_img == "1") {
   jQuery("img").mousedown(function(){
    return false;
   });
}


async function watermarkImage(originalImage, watermarkImagePath) {
   const canvas = document.createElement("canvas");
   const context = canvas.getContext("2d");
 
   const canvasWidth = originalImage.width;
   const canvasHeight = originalImage.height;
 
   canvas.width = canvasWidth;
   canvas.height = canvasHeight;
 
   // initializing the canvas with the original image
   context.drawImage(originalImage, 0, 0, canvasWidth, canvasHeight);
 
   // loading the watermark image and transforming it into a pattern
   const result = await fetch(watermarkImagePath);
   const blob = await result.blob();
   const image = await createImageBitmap(blob);
   const pattern = context.createPattern(image, "no-repeat");
   
   // translating the watermark image to the bottom right corner
   context.translate(canvasWidth - image.width, canvasHeight - image.height);
   context.rect(0, 0, canvasWidth, canvasHeight);
   context.fillStyle = pattern;
   
   context.fill();
 
   return canvas.toDataURL();
 }

 function watermarkImageWithText(originalImage, watermarkText) {
   const canvas = document.createElement("canvas");
   const context = canvas.getContext("2d");
 
   const canvasWidth = originalImage.width;
   const canvasHeight = originalImage.height;
 
   canvas.width = canvasWidth;
   canvas.height = canvasHeight;
 
   // initializing the canvas with the original image
   context.drawImage(originalImage, 0, 0, canvasWidth, canvasHeight);
 
   // adding a blue watermark text in the bottom right corner
   context.fillStyle = "blue";
   context.textBaseline = "middle";
   context.font = "bold 25px serif";
   context.fillText(watermarkText, canvasWidth - 100, canvasHeight - 20);
 
   return canvas.toDataURL();
 }
 
 

// This function adds a watermark to an individual image element
async function addWatermarkToImage(originalImage) {
   const watermarkedImage = new Image();
   watermarkedImage.src = await watermarkImage(originalImage, "/wp-content/uploads/2023/03/item3.jpg");
 
   const watermarkedImageWithText = new Image();
   watermarkedImageWithText.src = watermarkImageWithText(originalImage, "IMG.LY");
 
   originalImage.src=watermarkImageWithText(originalImage, "IMG.LY");
   originalImage.srcset=watermarkImageWithText(originalImage, "IMG.LY");

   return originalImage;
 }
 
 // This function processes all images with a specific class (e.g., "watermark-me")
 function processImagesWithWatermark() {
   const images = document.querySelectorAll("img");
   images.forEach((image) => {
     addWatermarkToImage(image);
   });
 
 }
 
 // Call the processImagesWithWatermark function when the page loads
 window.addEventListener("load", processImagesWithWatermark);