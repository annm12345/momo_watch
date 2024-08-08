<?php
require('top.php');
if(isset($_SESSION['USER_LOGIN']))
{
 $user_id=$_SESSION['USER_ID'];
 
}
?>
 <!-- Main Content -->
 <div class="content">
        <!-- Navbar -->
        <nav>
            <i class='bx bx-menu'></i>
            <!---<form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button class="search-btn" type="submit"><i class='bx bx-search'></i></button>
                </div>
            </form>--->
            <input type="checkbox" id="theme-toggle" hidden>
            <span>
                <?php 
                $user_res=mysqli_query($con,"select * from admin where id='$user_id'");
                $user_row=mysqli_fetch_assoc($user_res);
                echo $user_row['name'];
                ?>
            </span>
            <div id="datetime"></div>

            <script>
                function updateDateTime() {
                    const datetimeElement = document.getElementById('datetime');
                    const now = new Date();
                    const dateOptions = { year: 'numeric', month: 'long', day: 'numeric' };
                    const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit' };
                    const dateString = now.toLocaleDateString(undefined, dateOptions);
                    const timeString = now.toLocaleTimeString(undefined, timeOptions);
                    datetimeElement.textContent = dateString + ' ' + timeString;
                }

                // Update the date and time every second (1000 milliseconds)
                setInterval(updateDateTime, 1000);

                // Initial update
                updateDateTime();
            </script>
            
        </nav>

        <!-- End of Navbar -->

  
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
        button:hover{
            cursor:ponter;
        }
    </style>

        <h1>Sales Form</h1>
        <form id="sales-form" method="POST">
            <label for="product">Model No:</label>
            <select name="product_ids[]" style="padding:0.5rem;border-radius:5px;" id="product" required>
                <option value="">Model No ရွေးချယ်ပါ</option>
                <?php
                $res=mysqli_query($con,"SELECT * FROM `category` order by id asc");
                while($row=mysqli_fetch_assoc($res)){
                ?>
                <option value="<?php echo $row['name'] ?>"><?php echo $row['name'] ?></option>
                <?php } ?>
            </select>
            <label for="quantity">အရေအတွက်:</label>
            <input type="number" style="padding:0.5rem;border-radius:5px;" id="quantity" >
            <label for="price">တစ်ခုဈေး:</label>
            <input type="number" style="padding:0.5rem;border-radius:5px;" id="price" >
            <label for="price">လျော့ဈေး:</label>
            <input type="number" style="padding:0.5rem;border-radius:5px;" id="cupon" value="0" >
            <button type="button" style="padding:0.2rem;border-radius:5px;border:none;background:blue;font-size:1rem;color:#fff;" onclick="addItem()">ရေးသွင်းမည်</button>

           

        </form>
        <form action="insert.php" method="post">
            <table style="margin-top:1rem;">
                    <thead>
                        <tr>
                            <th>Model No</th>
                            <th>အရေအတွက်</th>
                            <th>တစ်ခုဈေး</th>
                            <th>လျော့ဈေး</th>
                            <th>စုစုပေါင်း</th>
                        </tr>
                    </thead>
                    <tbody id="sales-data">
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">Total:</td>
                            <td id="total">0.00</td>
                        </tr>
                    </tfoot>
                </table>
                <button type="submit" style="padding:0.5rem;border-radius:5px;border:none;background:blue;margin-top:1rem;margin-left:1rem;"><i class="fa-solid fa-floppy-disk" style="padding:0.5rem;font-size:1.3rem;color:#fff;"></i></button>
        </form>

        

        <script>
            function addItem() {
                const productSelect = document.getElementById("product");
                const productOption = productSelect.options[productSelect.selectedIndex];
                const modelNo = productOption.textContent;
                const quantity = parseFloat(document.getElementById("quantity").value);
                const price = parseFloat(document.getElementById("price").value);
                const cupon = parseFloat(document.getElementById("cupon").value);
                if (productSelect.value === "" || quantity.value === "" || price.value === "" || cupon.value === "") {
                alert("!အချက်အလက်ပြည့်စုံစွာ ဖြည့်သွင်းပါ");
                    return;
                }
                

                const total = (quantity * price)-cupon;
                const totalElement = document.getElementById("total");

                const row = document.createElement("tr");
                row.innerHTML = `
                    <td><input type="text" style="outline:none;border:none;background-color: #f2f2f2;font-size:1rem;text-align:center;" name="product[]" value="${modelNo}" ></td>
                    <td><input type="text" style="outline:none;border:none;background-color: #f2f2f2;font-size:1rem;text-align:center;" name="quantity[]" value="${quantity}" readonly></td>
                    <td><input type="text" style="outline:none;border:none;background-color: #f2f2f2;font-size:1rem;text-align:center;" name="price[]" value="${price}" readonly></td>
                    <td><input type="text" style="outline:none;border:none;background-color: #f2f2f2;font-size:1rem;text-align:center;" name="cupon[]" value="${cupon}" readonly></td>
                    <td><input type="text" style="outline:none;border:none;background-color: #f2f2f2;font-size:1rem;text-align:center;" name="total[]" value="${total.toFixed(2)}" readonly></td>
                    <td><button type="button" style="padding:0.2rem;border-radius:5px;" onclick="deleteItem(this)">Delete</button></td>
                `;

                const salesData = document.getElementById("sales-data");
                salesData.appendChild(row);

                const currentTotal = parseFloat(totalElement.innerText);
                totalElement.innerText = (currentTotal + total).toFixed(2);

                // Clear the form
                productSelect.value = ""; // Reset the dropdown selection
                document.getElementById("quantity").value = "0";
                document.getElementById("price").value = "0";
                document.getElementById("cupon").value = "0";
            }

            function deleteItem(button) {
            const row = button.parentElement.parentElement;
            const totalElement = document.getElementById("total");
            const totalValue = parseFloat(row.querySelector("input[name='total[]']").value);
            const currentTotal = parseFloat(totalElement.innerText);

            totalElement.innerText = (currentTotal - totalValue).toFixed(2);

            row.remove();
            }
        </script>
     </div>

<script src="index.js"></script>
</body>

</html>