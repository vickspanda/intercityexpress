function cancel_ticket() {
    var can = window.confirm("Do You Really Want To Cancel the Ticket ???");
    if (can === true) {
        var ticket_no = document.getElementById('ticket_no').value;
        window.location.href = 'cancel_ticket.php?ticket_no='+ticket_no;
    }
}

//May be this Code was not used
