BINARY=bin/mysql_proxyd
TARGET= $(BINARY)
HOME=../
CINC=-I/usr/local/tlibc/include/
LDPATH=-L/usr/local/tlibc/lib
DEPLIBS=-ltlibc
DEPOFILE=

CFILE=$(wildcard source/*.c)
DFILE=$(wildcard source/*.d)

include $(HOME)/build.mk

dep:
	@mkdir -p bin

install:
	mkdir -p $(PREFIX)
	cp -rf bin $(PREFIX)

