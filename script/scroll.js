const style = document.createElement('style');
style.innerHTML = `
  ::-webkit-scrollbar {
    width: 10px;
  }
  
  ::-webkit-scrollbar-track {
    background-color: none;
  }
  
  ::-webkit-scrollbar-thumb {
    border-radius: 10px;
    background-color: rgb(233, 233, 200);
  }
`;
document.head.appendChild(style);