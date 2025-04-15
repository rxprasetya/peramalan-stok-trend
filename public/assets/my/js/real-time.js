function isColorDark(color) {
    var r = parseInt(color.substr(1, 2), 16)
    var g = parseInt(color.substr(3, 2), 16)
    var b = parseInt(color.substr(5, 2), 16)
    var brightness = 0.2126 * r + 0.7152 * g + 0.0722 * b

    return brightness < 128 && Math.abs(r - g) > 40 && Math.abs(g - b) > 40 && Math.abs(r - b) > 40
}

$(document).ready(function () {

    const savedColor = localStorage.getItem('avatarColor')

    if (savedColor) {
        $('#avatar').css('background-color', savedColor)
    } else {
        let randomColor
        do {
            randomColor = `#${Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0')}`
        } while (!isColorDark(randomColor))

        $('#avatar').css('background-color', randomColor)
        localStorage.setItem('avatarColor', randomColor)
    }

    $('#btn-login').on('click', function () {
        let randomColor
        do {
            randomColor = `#${Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0')}`
        } while (!isColorDark(randomColor))

        localStorage.setItem('avatarColor', randomColor)
        $('#avatar').css('background-color', randomColor)
    })

    $('#btn-logout').on('click', function () {
        localStorage.removeItem('avatarColor')
    })

    $('#qtyPurchased, #cost').on('input', function () {

        let qtyPurchased = $('#qtyPurchased').val()
        let cost = $('#cost').val()

        if (!isNaN(qtyPurchased) && !isNaN(cost)) {
            let totalCost = qtyPurchased * cost
            $('#totalCost').val(totalCost)
        } else {
            $('#totalCost').val('')
        }

    })

    $('#qtySold, #sale').on('input', function () {

        let qtySold = $('#qtySold').val()
        let sale = $('#sale').val()

        if (!isNaN(qtySold) && !isNaN(sale)) {
            let totalSold = qtySold * sale
            $('#totalSold').val(totalSold)
        } else {
            $('#totalSold').val('')
        }

    })

    $('#itemID').change(function () {

        let selectedOption = $(this).find('option:selected')
        let unit = selectedOption.data('unit')

        $('.unitText').text(unit)

    })

    let initialUnit = $('#itemID').find('option:selected').data('unit')
    if (initialUnit) {
        $('.unitText').text(initialUnit)
    }

    $('#itemID, #stockDate').on('change', function () {
        let itemID = $('#itemID').val()
        let stockDate = $('#stockDate').val()

        if (itemID && stockDate) {
            $.ajax({
                url: '/stock/go-stock',
                method: 'POST',
                data: {
                    itemID: itemID,
                    stockDate: stockDate,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#stockOpening').val(response.openingStock)
                    $('#stockClosing').val(response.closingStock)
                    $('#qtySold').val(response.qtySold)
                    $('#qtyPurchased').val(response.qtyPurchased)
                },
                error: function () {
                    console.log(xhr.responseText)
                }
            })
        } else {
            $('#stockOpening').val('')
            $('#stockClosing').val('')
            $('#qtySold').val('')
            $('#qtyPurchased').val('')
        }
    })

    $('#itemID, #opnameDate').on('change', function () {
        let itemID = $('#itemID').val()
        let opnameDate = $('#opnameDate').val()

        if (itemID && opnameDate) {
            $.ajax({
                url: '/opname/gss-opname',
                method: 'POST',
                data: {
                    itemID: itemID,
                    opnameDate: opnameDate,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#systemStock').val(response.systemStock)
                },
                error: function () {
                    console.log(xhr.responseText)
                }
            })
        } else {
            $('#systemStock').val('')
        }
    })

    $('#systemStock, #physicalStock').on('input', function () {
        let systemStock = $('#systemStock').val()
        let physicalStock = $('#physicalStock').val()

        if (!isNaN(systemStock) && !isNaN(physicalStock)) {
            let result = physicalStock - systemStock

            $('#difference').val(result)
        } else {
            $('#difference').val('')
        }
    })

    $('#btn-forecast').on('click', function (e) {
        e.preventDefault()

        const year = $('#chooseYear').val()
        const item = $('#chooseItem').val()

        $.ajax({
            url: '/tm-forecasting',
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                chooseYear: year,
                chooseItem: item
            },
            beforeSend: function () {
                $('#btn-forecast').text('Processing...').attr('disabled', true)
            },
            success: function (response) {
                $('#btn-forecast').text('Process').attr('disabled', false)

                const tbody = $('#tableForecast tbody')
                tbody.empty()

                $.each(response.newDate, function (index, date) {
                    const forecast = response.roundedY[index]
                    const actual = response.y[index]
                    const er = response.er[index]
                    const absEr = response.absEr[index]
                    const resultAbsErAt = response.resultAbsErAt[index]

                    tbody.append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${response.itemName}</td>
                                <td>${date}</td>
                                <td>${actual}</td>
                                <td>${forecast}</td>
                            </tr>
                        `)
                })

                tbody.append(`
                <tr>
                    <td colspan="5">
                        Pengujian yang dilakukan dengan menggunakan perhitungan metode dan data aktual menghasilkan nilai akurasi MAPE rata rata sebesar 
                        <strong>
                            ${response.mape.toFixed(2)}%
                        </strong>    
                        serta menghasilkan kesimpulan 
                        <strong>
                            ${response.resultCategory}
                        </strong>
                    </td>
                </tr>
            `)

            },
            error: function (xhr, status, error) {
                $('#btn-forecast').text('Process').attr('disabled', false)
                console.log([xhr, status, error]);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong, make sure the data is correct.',
                    confirmButtonText: 'OK',
                })
            }
        })
    })

    // $('#btn-forecast').on('click', function (e) {
    //     e.preventDefault()

    //     const month = $('#chooseMonth').val()
    //     const item = $('#chooseItem').val()

    //     $.ajax({
    //         url: '/tm-forecasting',
    //         type: "POST",
    //         data: {
    //             _token: $('meta[name="csrf-token"]').attr('content'),
    //             chooseMonth: month,
    //             chooseItem: item
    //         },
    //         beforeSend: function () {
    //             $('#btn-forecast').text('Processing...').attr('disabled', true)
    //         },
    //         success: function (response) {
    //             $('#btn-forecast').text('Process').attr('disabled', false)

    //             const tbody = $('#tableForecast tbody')
    //             tbody.empty()

    //             $.each(response.newDate, function (index, date) {
    //                 const forecast = response.roundedY[index]
    //                 const actual = response.y[index]
    //                 const er = response.er[index]
    //                 const absEr = response.absEr[index]
    //                 const resultAbsErAt = response.resultAbsErAt[index]


    //                 tbody.append(`
    //                         <tr>
    //                             <td>${index + 1}</td>
    //                             <td>${response.itemName}</td>
    //                             <td>${date}</td>
    //                             <td>${actual}</td>
    //                             <td>${forecast}</td>
    //                             <td>${er}</td>
    //                             <td>${absEr}</td>
    //                             <td>${resultAbsErAt.toFixed(8)}</td>
    //                         </tr>
    //                     `)
    //             })

    //             tbody.append(`
    //             <tr>
    //                 <td colspan="2">Sum AE / AT</td>
    //                 <td colspan="6">${response.sumAbsErAt}</td>
    //             </tr>
    //             <tr>
    //                 <td colspan="2">MAPE</td>
    //                 <td colspan="6">${response.mape.toFixed(2)} %</td>
    //             </tr>
    //             <tr>
    //                <td colspan="8">
    //                     Pengujian yang dilakukan dengan menggunakan perhitungan metode dan data aktual menghasilkan nilai akurasi MAPE rata rata sebesar 
    //                     <strong>
    //                         ${response.mape.toFixed(2)}%
    //                     </strong>    
    //                         serta menghasilkan kesimpulan 
    //                     <strong>
    //                         ${response.resultCategory}
    //                      </strong>
    //                 </td>
    //             </tr>
    //         `)

    //         },
    //         error: function (xhr, status, error) {
    //             $('#btn-forecast').text('Process').attr('disabled', false)
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Error',
    //                 text: 'Something went wrong, make sure the data is correct.',
    //                 confirmButtonText: 'OK',
    //             })
    //         }
    //     })
    // })

})