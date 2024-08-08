<?php
require('top.php');
if(isset($_SESSION['USER_LOGIN'])) {
    $user_id = $_SESSION['USER_ID'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
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

        button:hover {
            cursor: pointer;
        }

        .search button {
            background: #080342 !important;
            padding: 10px 20px;
            color: #fff !important;
            font-size: 1rem;
        }

        .form-control,
        .selectpicker {
            padding: 0.5rem;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="content">
        <!-- Navbar -->
        <nav>
            <i class='bx bx-menu'></i>
            <input type="checkbox" id="theme-toggle" hidden>
            <span>
                <?php 
                $user_res = mysqli_query($con, "SELECT * FROM user WHERE id='$user_id'");
                $user_row = mysqli_fetch_assoc($user_res);
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

                setInterval(updateDateTime, 1000);
                updateDateTime();
            </script>
        </nav>
        <!-- End of Navbar -->

        <h1>Sales Form</h1>
        <form id="sales-form" method="POST">
            <div class="form-group">
                <label for="product">Model No:</label>
                <select name="product_id[]" id="product" class="form-control selectpicker" onchange="select();" data-live-search="true" required>
                    <option value="">Model No ရွေးချယ်ပါ</option>
                    <?php
                    $res = mysqli_query($con, "SELECT * FROM `items` ORDER BY catid ASC");
                    while($row = mysqli_fetch_assoc($res)){
                        $cat_id = $row['catid'];
                        $cat_res = mysqli_query($con, "SELECT * FROM `category` WHERE id='$cat_id'");
                        $cat_row = mysqli_fetch_assoc($cat_res);
                        $cat_name = $cat_row['name'];
                    ?>
                    <option value="<?php echo $row['id'] ?>"><?php echo $cat_name ?> <?php echo $row['model'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <input type="hidden" name="item_id[]" id="item">
            <div class="form-group">
                <label for="quantity">အရေအတွက်:</label>
                <input type="number" class="form-control" id="quantity">
            </div>
            <div class="form-group">
                <label for="price">တစ်ခုဈေး:</label>
                <input type="number" class="form-control" id="price">
            </div>
            <div class="form-group">
                <label for="cupon">လျော့ဈေး:</label>
                <input type="number" class="form-control" id="cupon" value="0">
            </div>
            <button type="button" class="btn btn-primary" onclick="addItem()">ရေးသွင်းမည်</button>
        </form>

        <form action="insert.php?id=<?php echo $user_id ?>" method="post">
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>Model No</th>
                        <th syle="display:none"></th>
                        <th>အရေအတွက်</th>
                        <th>တစ်ခုဈေး</th>
                        <th>လျော့ဈေး</th>
                        <th>စုစုပေါင်း</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="sales-data">
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">Total:</td>
                        <td id="total">0.00</td>
                    </tr>
                </tfoot>
            </table>
            <button type="submit" class="btn btn-success mt-4 ml-4">
                <i class="fa-solid fa-floppy-disk" style="padding:0.5rem;font-size:1.3rem;color:#fff;"></i>
            </button>
        </form>

        <script src="jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
        <script>
            $(document).ready(function(){
                $('select').selectpicker();
            });

            function select() {
                const productSelect = document.getElementById("product");
                const productOption = productSelect.options[productSelect.selectedIndex];
                const modelNo = productOption.value;
                
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const price = JSON.parse(xhr.responseText).price;
                        document.getElementById("price").value = price;
                        document.getElementById("item").value = modelNo;
                    }
                };
                xhr.open("GET", "get_price.php?model=" + modelNo, true);
                xhr.send();
            }

            function addItem() {
                const productSelect = document.getElementById("product");
                const productOption = productSelect.options[productSelect.selectedIndex];
                const modelNo = productOption.textContent;
                const item = parseFloat(document.getElementById("item").value);
                const quantity = parseFloat(document.getElementById("quantity").value);
                const price = parseFloat(document.getElementById("price").value);
                const cupon = parseFloat(document.getElementById("cupon").value);

                if (productSelect.value === "" || isNaN(quantity) || isNaN(price) || isNaN(cupon)) {
                    alert("!အချက်အလက်ပြည့်စုံစွာ ဖြည့်သွင်းပါ");
                    return;
                }

                const total = (quantity * price) - cupon;
                const totalElement = document.getElementById("total");

                const row = document.createElement("tr");
                row.innerHTML = `
                    <td><input type="text" style="outline:none;border:none;background-color: #f2f2f2;font-size:1rem;text-align:center;" name="product[]" value="${modelNo}" readonly></td>
                    <td style="display:none"><input type="text" style="outline:none;border:none;background-color: #f2f2f2;font-size:1rem;text-align:center;display:none;" name="item[]" value="${item}" readonly></td>
                    <td><input type="text" style="outline:none;border:none;background-color: #f2f2f2;font-size:1rem;text-align:center;" name="quantity[]" value="${quantity}" readonly></td>
                    <td><input type="text" style="outline:none;border:none;background-color: #f2f2f2;font-size:1rem;text-align:center;" name="price[]" value="${price}" readonly></td>
                    <td><input type="text" style="outline:none;border:none;background-color: #f2f2f2;font-size:1rem;text-align:center;" name="cupon[]" value="${cupon}" readonly></td>
                    <td><input type="text" style="outline:none;border:none;background-color: #f2f2f2;font-size:1rem;text-align:center;" name="total[]" value="${total.toFixed(2)}" readonly></td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="deleteItem(this)">Delete</button></td>
                `;

                const salesData = document.getElementById("sales-data");
                salesData.appendChild(row);

                const currentTotal = parseFloat(totalElement.innerText);
                totalElement.innerText = (currentTotal + total).toFixed(2);

                // Clear the form
                productSelect.value = "";
                $('.selectpicker').selectpicker('refresh'); // Refresh the select picker
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
</body>
</html>
