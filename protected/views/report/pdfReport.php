<style>
th,td
{
background-color:white;
color:black;
font-family: "Times New Roman"; 
font-size: 14;
}
th
{
height:40px;
} 
table
{
width: 100%;
border-collapse:collapse;
border: 1px solid green;
}
th,td
{

border:1px solid black;
}

h1
{
color:buttonface;
text-align:center;
}
td
{
height:20px;
vertical-align:top;
}
p
{
color:black;
text-align:center;

font-family:"Times New Roman";
font-size:20px;
}
.tbl
{
font-family: "Times New Roman"; 
font-size: 14;
}


</style>
<h1>MedcoEMR Patient Report</h1>
<div>
    <strong>   Gender: </strong> <?php echo ucfirst($gender); ?> 
</div>
 <div>         
                        
            <?php if(!empty($fromDate)){
                       echo  "<strong> From: &nbsp; &nbsp; </strong>";
                       echo $fromDate;
            }?> 
                &nbsp; 
                &nbsp;
                        
                <?php if(!empty($toDate)){
                    echo  "<strong> To: &nbsp; &nbsp; </strong>";
                    echo $toDate;
                    
                }?>
            
 </div>

</br>
</br>

        <TR>
            <th style="text-align: center">S.N.</th>
            <th style="text-align: center; width: 10%">Card ID</th>
            <th style="text-align: center">First Name</th>
            <th style="text-align: center">Mobile Phone</th>
            <th style="text-align: center">Complain</th>
        </TR>

</br>
</br>
</br>
<div  style="text-align:right; font-size: 8">

  Medium Health Care Pvt. Ltd

</div>