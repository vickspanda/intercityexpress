from flask import Flask, request, send_file
from reportlab.lib.pagesizes import letter
from reportlab.pdfgen import canvas
import io

app = Flask(__name__)

def create_ticket_pdf(ticket_info):
    """
    Generate a PDF for a train ticket.
    :param ticket_info: A dictionary containing ticket details
    :return: BytesIO object containing the PDF
    """
    buffer = io.BytesIO()
    c = canvas.Canvas(buffer, pagesize=letter)
    width, height = letter

    # Define margins
    margin_x = 50
    margin_y = 50

    # Title
    c.setFont("Helvetica-Bold", 24)
    c.drawString(margin_x, height - margin_y, "Train Ticket")

    # Draw a line
    c.setLineWidth(1)
    c.line(margin_x, height - margin_y - 20, width - margin_x, height - margin_y - 20)

    # Ticket details
    c.setFont("Helvetica", 12)
    y_position = height - margin_y - 50
    line_height = 14

    for key, value in ticket_info.items():
        c.drawString(margin_x, y_position, f"{key}: {value}")
        y_position -= line_height

    # Save the PDF
    c.save()
    buffer.seek(0)
    return buffer

@app.route('/generate_ticket', methods=['POST'])
def generate_ticket():
    ticket_info = request.json
    pdf_buffer = create_ticket_pdf(ticket_info)
    return send_file(pdf_buffer, as_attachment=True, download_name='train_ticket.pdf', mimetype='application/pdf')

if __name__ == '__main__':
    app.run(debug=True)
