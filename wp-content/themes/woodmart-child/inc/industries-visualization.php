<?php
.rs-industries-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
}

.rs-industry-card {
    position: relative;
    overflow: hidden;
    border-radius: 5px;
/*     background: #fff;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08); */
    cursor: pointer;
}

.rs-industry-image img {
    width: 100%;
    height: 260px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

/* Image zoom on hover */
.rs-industry-card:hover .rs-industry-image img {
    transform: scale(1.08);
}

/* Content overlay */
.rs-industry-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 0px 20px;
    background-color: #0000008c;
}
/* Title */
.rs-industry-content h4 {
    margin: 0px 0px -30px 0px;
    font-size: 25px;
    font-weight: 900;
    color: #fff;
    line-height: 1.3;
	transition: all 0.4s ease;
}
/* Title Slide up on hover */
.rs-industry-card:hover .rs-industry-content h4 {
    margin: 0px 0px -10px 0px;
}

/* Hidden description */
.rs-industry-content p {
    color: #fff;
    margin: 10px 0px 10px 0px;
    font-size: 16px;
	font-weight: 100;
    line-height: 1;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.4s ease;
}

/* Slide up on hover */
.rs-industry-card:hover .rs-industry-content p {
    opacity: 1;
    transform: translateY(0);
}