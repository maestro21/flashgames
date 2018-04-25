/** modal **/

.modal {
  background-color: white;
  border-radius: 10px;
  display: none;
  max-height: calc(100% - 100px);
  position: fixed;
  top: 50%;
  left: 50%;
  right: auto;
  bottom: auto;
  transform: translate(-50%, -50%);
  z-index:1000;
  padding:10px;
  -webkit-box-shadow: 0 0 10px #000;
        box-shadow: 0 0 10px #000;
  /* overflow:auto; */
}
.modal-body  {
	padding:10px;
	height: 100%;
    overflow: auto;
}

.modal-overlay {
  background-color: rgba(0, 0, 0, 0.5);
  display: none;
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 980;
}
.modal-close {
	cursor:pointer;
	z-index:20003;
	position:inherit;
	top:-20px;
	right:-20px;
}


.modal h2 {	
    margin: 0;
	margin-bottom: 10px;
}